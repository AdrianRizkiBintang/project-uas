<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])->latest()->paginate(15);
        return view('manager.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.menu']);
        return view('manager.order.show', compact('order'));
    }

    public function updateStatus(Order $order, string $status)
    {
        $order->update(['status' => $status]);
        return back()->with('success', 'Status pesanan diupdate!');
    }
}