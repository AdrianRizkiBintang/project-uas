<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Promo;
use Illuminate\Http\Request;

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

        return view('home.index', compact('outlets', 'promos'));
    }
}
