<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $validated = $request->validate([
            'menu_id'    => 'required|exists:menus,id',
            'quantity'   => 'required|integer|min:1',
            'notes'      => 'nullable|string|max:200',
            'outlet_id'  => 'required|exists:outlets,id',
            'order_type' => 'required|in:dine_in,delivery',
        ]);

        $menu      = Menu::findOrFail($validated['menu_id']);
        $cartKey   = $validated['order_type'] === 'dine_in' ? 'cart' : 'delivery_cart';
        $outletKey = $validated['order_type'] === 'dine_in' ? 'cart_outlet_id' : 'delivery_cart_outlet_id';

        $cart = session($cartKey, []);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity'] += $validated['quantity'];
        } else {
            $cart[$menu->id] = [
                'name'     => $menu->name,
                'price'    => (float) $menu->price,
                'quantity' => $validated['quantity'],
                'notes'    => $validated['notes'] ?? null,
                'image'    => $menu->image,
            ];
        }

        session([$cartKey => $cart, $outletKey => $validated['outlet_id']]);

        return redirect()->back()->with('success', $menu->name . ' ditambahkan ke keranjang.');
    }

    public function update(Request $request, $menuId)
    {
        $validated = $request->validate([
            'quantity'   => 'required|integer|min:1',
            'order_type' => 'required|in:dine_in,delivery',
        ]);

        $cartKey = $validated['order_type'] === 'dine_in' ? 'cart' : 'delivery_cart';
        $cart    = session($cartKey, []);

        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity'] = $validated['quantity'];
            session([$cartKey => $cart]);
        }

        return redirect()->back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Request $request, $menuId)
    {
        $orderType = $request->query('type', 'dine_in');
        $cartKey   = $orderType === 'dine_in' ? 'cart' : 'delivery_cart';
        $cart      = session($cartKey, []);

        unset($cart[$menuId]);
        session([$cartKey => $cart]);

        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }
}
