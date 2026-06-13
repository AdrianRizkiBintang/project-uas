<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan dengan fitur filter
     * berdasarkan status, tipe pesanan, dan tanggal.
     * Hasil ditampilkan dengan pagination 15 item per halaman.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Mulai query dengan relasi user dan items
        $query = Order::with(['user', 'items'])->latest();

        // Filter berdasarkan status pesanan jika diisi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tipe pesanan (dine_in / delivery) jika diisi
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan tanggal pesanan jika diisi
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Paginate hasil dan pertahankan query string di URL
        $orders = $query->paginate(15)->withQueryString();

        return view('manager.order.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan beserta item menu
     * dan informasi user yang memesan.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        // Load relasi user, items, dan menu dari setiap item
        $order->load(['user', 'items.menu']);
        return view('manager.order.show', compact('order'));
    }

    /**
     * Memperbarui status pesanan.
     * Hanya status yang terdaftar dalam daftar allowed yang dapat digunakan.
     *
     * @param  \App\Models\Order  $order
     * @param  string  $status  Status baru yang akan diterapkan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Order $order, string $status)
    {
        // Daftar status pesanan yang diizinkan
        $allowed = ['pending', 'confirmed', 'processing', 'out_for_delivery', 'completed', 'cancelled'];

        // Tolak jika status yang dikirim tidak valid
        if (!in_array($status, $allowed)) {
            return back()->with('error', 'Status tidak valid!');
        }

        $order->update(['status' => $status]);
        return back()->with('success', 'Status pesanan diupdate!');
    }
}