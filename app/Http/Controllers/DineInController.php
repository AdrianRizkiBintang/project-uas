<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Ambil menu yang tersedia di outlet, dengan filter opsional
        $menus = Menu::where('outlet_id', $outletId)
            ->where('is_available', true)
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($category, fn($q) => $q->where('category', $category))
            ->get();

        // Ambil daftar kategori yang tersedia untuk filter
        $categories = Menu::where('outlet_id', $outletId)->distinct()->pluck('category');

        return view('dine-in.menu', compact('outlet', 'menus', 'categories', 'search', 'category'));
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
        // Ambil data keranjang dari session
        $cart   = session('cart', []);
        $outlet = null;

        // Jika keranjang tidak kosong, ambil data outlet terkait
        if (!empty($cart)) {
            $outletId = session('cart_outlet_id');
            $outlet   = Outlet::find($outletId);
        }

        return view('dine-in.cart', compact('cart', 'outlet'));
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
        // Validasi input checkout
        $validated = $request->validate([
            'outlet_id'      => 'required|exists:outlets,id',
            'payment_method' => 'required|in:cash,qris',
            'notes'          => 'nullable|string|max:500',
        ]);

        $cart = session('cart', []);

        // Batalkan jika keranjang kosong
        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Keranjang kosong.']);
        }

        $order = null;

        // Gunakan transaksi DB agar order dan item tersimpan atomik
        DB::transaction(function () use ($validated, $cart, &$order) {

            // Hitung total harga dari semua item di keranjang
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Buat record order baru
            $order = Order::create([
                'user_id'         => auth()->id(),
                'outlet_id'       => $validated['outlet_id'],
                'type'            => 'dine_in',
                'status'          => 'pending',
                'payment_method'  => $validated['payment_method'],
                'payment_status'  => 'unpaid',
                'total_amount'    => $total,
                'discount_amount' => 0,
                'notes'           => $validated['notes'] ?? null,
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

        // Hapus data keranjang dari session setelah checkout berhasil
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