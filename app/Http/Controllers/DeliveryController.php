<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    /**
     * Menampilkan halaman pemilihan alamat pengiriman.
     * Daftar alamat diambil dari relasi user yang sedang login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function address(Request $request)
    {
        $addresses = auth()->user()->addresses;
        return view('delivery.address', compact('addresses'));
    }

    /**
     * Menampilkan halaman pemilihan outlet untuk pengiriman.
     * Membutuhkan address_id dari langkah sebelumnya.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function outlet(Request $request)
    {
        $addressId = $request->query('address_id');

        // Redirect kembali jika address_id tidak ada di query string
        if (!$addressId) {
            return redirect()->route('delivery.address');
        }

        $outlets = Outlet::all();

        return view('delivery.outlet', compact('outlets', 'addressId'));
    }

    /**
     * Menampilkan halaman daftar menu delivery dari outlet yang dipilih.
     * Mendukung filter pencarian berdasarkan nama dan kategori menu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function menu(Request $request)
    {
        $outletId = $request->query('outlet_id');
        $outlet   = Outlet::findOrFail($outletId);
        $search   = $request->query('search');
        $category = $request->query('category');

        // Ambil menu yang tersedia di outlet dengan filter opsional
        $menus = Menu::where('outlet_id', $outletId)
            ->where('is_available', true)
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($category, fn($q) => $q->where('category', $category))
            ->get();

        // Ambil semua kategori unik untuk keperluan filter dropdown
        $categories = Menu::where('outlet_id', $outletId)
            ->distinct()
            ->pluck('category');

        return view('delivery.menu', compact('outlet', 'menus', 'categories', 'search', 'category'));
    }

    /**
     * Menampilkan halaman keranjang belanja untuk alur delivery.
     * Data keranjang dan promo aktif ditampilkan di halaman ini.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function cart(Request $request)
    {
        // Ambil data keranjang delivery dari session
        $cart   = session('delivery_cart', []);
        $outlet = null;

        // Jika keranjang tidak kosong, ambil outlet yang terkait
        if (!empty($cart)) {
            $outletId = session('delivery_cart_outlet_id');
            $outlet   = Outlet::find($outletId);
        }

        // Ambil daftar promo yang masih aktif dan belum kadaluarsa
        $promos = Promo::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expiration_date')
                  ->orWhere('expiration_date', '>', now());
            })
            ->get();

        return view('delivery.cart', compact('cart', 'outlet', 'promos'));
    }

    /**
     * Memproses checkout pesanan delivery.
     * Menghitung diskon promo jika ada, lalu membuat Order dan OrderItem
     * dalam satu transaksi database untuk menjaga konsistensi data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(Request $request)
    {
        // Validasi semua input checkout delivery
        $validated = $request->validate([
            'outlet_id'           => 'required|exists:outlets,id',
            'delivery_address_id' => 'required|exists:user_addresses,id',
            'payment_method'      => 'required|in:cash,qris',
            'notes'               => 'nullable|string|max:500',
            'promo_code'          => 'nullable|string',
        ]);

        $cart = session('delivery_cart', []);

        // Batalkan jika keranjang kosong
        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Keranjang kosong.']);
        }

        $promo          = null;
        $discountAmount = 0;

        // Validasi dan ambil data promo jika kode promo diisi
        if (!empty($validated['promo_code'])) {
            $promo = Promo::where('code', $validated['promo_code'])->first();

            if (!$promo || !$promo->isValid()) {
                return back()->withErrors([
                    'promo_code' => 'Kode promo tidak valid atau sudah kadaluarsa.'
                ]);
            }
        }

        $order = null;

        // Gunakan transaksi DB agar semua data tersimpan secara atomik
        DB::transaction(function () use ($validated, $cart, $promo, &$order, &$discountAmount) {

            // Hitung subtotal dari semua item di keranjang
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            // Hitung diskon berdasarkan tipe promo (persentase atau nominal)
            if ($promo) {
                $discountAmount = $promo->discount_type === 'percentage'
                    ? $subtotal * ($promo->discount_value / 100)
                    : min((float) $promo->discount_value, $subtotal);

                // Tambah hitungan penggunaan promo
                $promo->increment('used_count');
            }

            // Buat record order baru dengan total setelah diskon
            $order = Order::create([
                'user_id'             => auth()->id(),
                'outlet_id'           => $validated['outlet_id'],
                'type'                => 'delivery',
                'status'              => 'pending',
                'payment_method'      => $validated['payment_method'],
                'payment_status'      => 'unpaid',
                'total_amount'        => max(0, $subtotal - $discountAmount),
                'discount_amount'     => $discountAmount,
                'notes'               => $validated['notes'] ?? null,
                'delivery_address_id' => $validated['delivery_address_id'],
                'promo_id'            => $promo?->id,
            ]);

            // Simpan setiap item dari keranjang sebagai OrderItem
            foreach ($cart as $menuId => $item) {
                $order->items()->create([
                    'menu_id'       => $menuId,
                    'quantity'      => $item['quantity'],
                    'price_at_time' => $item['price'],
                    'notes'         => $item['notes'] ?? null,
                ]);
            }
        });

        // Hapus data keranjang delivery dari session setelah checkout
        session()->forget(['delivery_cart', 'delivery_cart_outlet_id']);

        return redirect()->route('delivery.track', $order);
    }

    /**
     * Menampilkan halaman tracking status pesanan delivery.
     * Hanya pemilik pesanan yang dapat mengakses halaman ini.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function track(Order $order)
    {
        // Pastikan pesanan milik user yang sedang login
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items.menu', 'outlet', 'deliveryAddress', 'review');

        return view('delivery.track', compact('order'));
    }
}