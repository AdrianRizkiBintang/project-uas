<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function address(Request $request)
    {
        $addresses = auth()->user()->addresses;
        return view('delivery.address', compact('addresses'));
    }

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

        return view('delivery.menu', compact('outlet', 'menus', 'categories', 'search', 'category'));
    }

    public function cart(Request $request)
    {
        $cart   = session('delivery_cart', []);
        $outlet = null;

        if (!empty($cart)) {
            $outletId = session('delivery_cart_outlet_id');
            $outlet   = Outlet::find($outletId);
        }

        $promos = Promo::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expiration_date')->orWhere('expiration_date', '>', now());
            })->get();

        return view('delivery.cart', compact('cart', 'outlet', 'promos'));
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'outlet_id'          => 'required|exists:outlets,id',
            'delivery_address_id'=> 'required|exists:user_addresses,id',
            'payment_method'     => 'required|in:cash,qris',
            'notes'              => 'nullable|string|max:500',
            'promo_code'         => 'nullable|string',
        ]);

        $cart = session('delivery_cart', []);
        if (empty($cart)) {
            return back()->withErrors(['cart' => 'Keranjang kosong.']);
        }

        $promo          = null;
        $discountAmount = 0;

        if (!empty($validated['promo_code'])) {
            $promo = Promo::where('code', $validated['promo_code'])->first();
            if (!$promo || !$promo->isValid()) {
                return back()->withErrors(['promo_code' => 'Kode promo tidak valid atau sudah kadaluarsa.']);
            }
        }

        $order = null;
        DB::transaction(function () use ($validated, $cart, $promo, &$order, &$discountAmount) {
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            if ($promo) {
                $discountAmount = $promo->discount_type === 'percentage'
                    ? $subtotal * ($promo->discount_value / 100)
                    : min((float) $promo->discount_value, $subtotal);
                $promo->increment('used_count');
            }

            $order = Order::create([
                'user_id'            => auth()->id(),
                'outlet_id'          => $validated['outlet_id'],
                'type'               => 'delivery',
                'status'             => 'pending',
                'payment_method'     => $validated['payment_method'],
                'payment_status'     => 'unpaid',
                'total_amount'       => max(0, $subtotal - $discountAmount),
                'discount_amount'    => $discountAmount,
                'notes'              => $validated['notes'] ?? null,
                'delivery_address_id'=> $validated['delivery_address_id'],
                'promo_id'           => $promo?->id,
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

        session()->forget(['delivery_cart', 'delivery_cart_outlet_id']);

        return redirect()->route('delivery.track', $order);
    }

    public function track(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        $order->load('items.menu', 'outlet', 'deliveryAddress', 'review');

        return view('delivery.track', compact('order'));
    }
}
