<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_menu'    => Menu::count(),
            'total_outlet'  => Outlet::count(),
            'total_order'   => Order::count(),
            'total_user'    => User::where('role', 'customer')->count(),
        ];

        $recent_orders = Order::with('user')->latest()->take(10)->get();

        return view('manager.dashboard', compact('stats', 'recent_orders'));
    }
}