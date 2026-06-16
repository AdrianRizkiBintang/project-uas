<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $wishlists = $request->user()->wishlists()->with('menu.outlet')->latest()->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request, Menu $menu)
    {
        $existing = Wishlist::where('user_id', $request->user()->id)
            ->where('menu_id', $menu->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Dihapus dari wishlist.';
        } else {
            Wishlist::create([
                'user_id' => $request->user()->id,
                'menu_id' => $menu->id,
            ]);
            $message = 'Ditambahkan ke wishlist.';
        }

        return redirect()->back()->with('success', $message);
    }
}