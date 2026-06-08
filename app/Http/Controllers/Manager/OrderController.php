<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('manager.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.menu']);
        return view('manager.order.show', compact('order'));
    }

    public function updateStatus(Order $order, string $status)
    {
        $allowed = ['pending', 'confirmed', 'processing', 'out_for_delivery', 'completed', 'cancelled'];

        if (!in_array($status, $allowed)) {
            return back()->with('error', 'Status tidak valid!');
        }

        $order->update(['status' => $status]);
        return back()->with('success', 'Status pesanan diupdate!');
    }
}