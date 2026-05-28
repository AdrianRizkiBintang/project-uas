<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DineInController extends Controller
{
    public function menu(Request $request)
    {
        $outletId  = $request->query('outlet_id');
        $outlet    = Outlet::findOrFail($outletId);
        $search    = $request->query('search');
        $category  = $request->query('category');

        $menus = Menu::where('outlet_id', $outletId)
            ->where('is_available', true)
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($category, fn($q) => $q->where('category', $category))
            ->get();

        $categories = Menu::where('outlet_id', $outletId)->distinct()->pluck('category');

        return view('dine-in.menu', compact('outlet', 'menus', 'categories', 'search', 'category'));
    }

    public function cart(Request $request)
    {
        $cart   = session('cart', []);
        $outlet = null;

        if (!empty($cart)) {
            $outletId = session('cart_outlet_id');
            $outlet   = Outlet::find($outletId);
        }

        return view('dine-in.cart', compact('cart', 'outlet'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'outlet_id'      => 'required|exists:outlets,id',
            'payment_method' => 'required|in:cash,qris',
            'notes'          => 'nullable|string|max:500',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Keranjang kosong.']);
        }

        $order = null;
        DB::transaction(function () use ($validated, $cart, &$order) {
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $order = Order::create([
                'user_id'        => auth()->id(),
                'outlet_id'      => $validated['outlet_id'],
                'type'           => 'dine_in',
                'status'         => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'unpaid',
                'total_amount'   => $total,
                'discount_amount'=> 0,
                'notes'          => $validated['notes'] ?? null,
            ]);

            foreach ($cart as $menuId => $item) {
                $order->items()->create([
                    'menu_id'       => $menuId,
                    'quantity'      => $item['quantity'],
                    'price_at_time' => $item['price'],
                    'notes'         => $item['notes'] ?? null,
                ]);
            }
        });

        session()->forget(['cart', 'cart_outlet_id']);

        return redirect()->route('dine-in.track', $order);
    }

    public function track(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        $order->load('items.menu', 'outlet', 'review');

        return view('dine-in.track', compact('order'));
    }
}
