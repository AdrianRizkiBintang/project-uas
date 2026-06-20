<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    $todayRevenue = Order::sum('total_amount');

    $recent_orders = Order::with('user')->latest()->take(10)->get();

    return view('manager.dashboard', compact(
        'stats',
        'recent_orders',
        'todayRevenue'
    ));
}

   public function revenue()
{
    $dailyRevenue = Order::select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(total_amount) as revenue'),
        DB::raw('COUNT(*) as total_orders')
    )
    ->groupBy('date')
    ->orderByDesc('date')
    ->get();

    return view('manager.revenue', compact('dailyRevenue'));
}

}

