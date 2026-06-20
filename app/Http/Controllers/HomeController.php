<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\OrderItem;
use App\Models\Outlet;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $outlets = Outlet::where('status', 'open')->get();
        $promos  = Promo::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expiration_date')
                  ->orWhere('expiration_date', '>', now());
            })
            ->get();

        $bestSellerIds = OrderItem::select('menu_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('menu_id')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->pluck('menu_id');

        $bestSellers = Menu::whereIn('id', $bestSellerIds)
            ->where('is_available', true)
            ->with('outlet')
            ->get()
            ->sortBy(fn($menu) => array_search($menu->id, $bestSellerIds->toArray()))
            ->values();

        return view('home.index', compact('outlets', 'promos', 'bestSellers'));
    }
}