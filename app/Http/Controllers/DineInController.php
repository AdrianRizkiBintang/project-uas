<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Promo;

class DineInController extends Controller
{
    /**
     * Menampilkan halaman daftar menu untuk alur dine-in.
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
    $sort     = $request->query('sort');

    $menus = Menu::where('outlet_id', $outletId)
        ->where('is_available', true)
        ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
        ->when($category, fn($q) => $q->where('category', $category))
        ->when($sort === 'price_asc', fn($q) => $q->orderBy('price', 'asc'))
        ->when($sort === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
        ->when($sort === 'name_asc', fn($q) => $q->orderBy('name', 'asc'))
        ->when($sort === 'name_desc', fn($q) => $q->orderBy('name', 'desc'))
        ->get();

    $categories = Menu::where('outlet_id', $outletId)
        ->distinct()
        ->pluck('category');

    return view(
        'dine-in.menu',
        compact(
            'outlet',
            'menus',
            'categories',
            'search',
            'category',
            'sort'
        )
    );
}

    /**
     * Menampilkan halaman keranjang belanja untuk alur dine-in.
     * Data keranjang diambil dari session yang tersimpan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
   public function cart(Request $request)
    {
        $cart   = session('cart', []);
        $outlet = null;

        if (!empty($cart)) {
            $outletId = session('cart_outlet_id');
            $outlet   = Outlet::find($outletId);
        }

        $promos = Promo::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expiration_date')->orWhere('expiration_date', '>', now());
            })->get();

        return view('dine-in.cart', compact('cart', 'outlet', 'promos'));
    }

    /**
     * Memproses checkout pesanan dine-in.
     * Membuat Order dan OrderItem dalam satu transaksi database
     * untuk memastikan konsistensi data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
   public function checkout(Request $request)
    {
        $validated = $request->validate([
            'outlet_id'      => 'required|exists:outlets,id',
            'payment_method' => 'required|in:cash,qris',
            'notes'          => 'nullable|string|max:500',
            'promo_code'     => 'nullable|string',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Keranjang kosong.']);
        }

        $promo = null;
        if (!empty($validated['promo_code'])) {
            $promo = Promo::where('code', $validated['promo_code'])->first();
            if (!$promo || !$promo->isValid()) {
                return back()->withErrors(['promo_code' => 'Kode promo tidak valid atau sudah kadaluarsa.']);
            }
        }

        $order = null;
        DB::transaction(function () use ($validated, $cart, $promo, &$order) {
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $discountAmount = 0;
            if ($promo) {
                $discountAmount = $promo->discount_type === 'percentage'
                    ? $subtotal * ($promo->discount_value / 100)
                    : min((float) $promo->discount_value, $subtotal);
                $promo->increment('used_count');
            }

            $order = Order::create([
                'user_id'        => auth()->id(),
                'outlet_id'      => $validated['outlet_id'],
                'type'           => 'dine_in',
                'status'         => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'unpaid',
                'total_amount'   => max(0, $subtotal - $discountAmount),
                'discount_amount'=> $discountAmount,
                'notes'          => $validated['notes'] ?? null,
                'promo_id'       => $promo?->id,
            ]);

            foreach ($cart as $menuId => $item) {
                $order->items()->create([
                    'menu_id'       => $menuId,
                    'quantity'      => $item['quantity'],
                    'price_at_time' => $item['price'],
                    'notes'         => $item['notes'] ?? null,
                ]);
            }
        });

        session()->forget(['cart', 'cart_outlet_id']);

        return redirect()->route('dine-in.track', $order);
    }

    /**
     * Menampilkan halaman tracking status pesanan dine-in.
     * Hanya pemilik pesanan yang dapat mengakses halaman ini.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function track(Order $order)
    {
        // Pastikan pesanan milik user yang sedang login
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items.menu', 'outlet', 'review');

        return view('dine-in.track', compact('order'));
    }
}