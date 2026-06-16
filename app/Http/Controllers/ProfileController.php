<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->safe()->except('avatar'));

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function history(Request $request): View
    {
        $orders = $request->user()->orders()
            ->with(['items.menu', 'outlet', 'review'])
            ->latest()
            ->paginate(10);

        return view('profile.history', compact('orders'));
    }

    public function reorder(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items.menu');

        $cartKey = $order->type === 'delivery'
            ? 'delivery_cart'
            : 'cart';

        $outletKey = $order->type === 'delivery'
            ? 'delivery_cart_outlet_id'
            : 'cart_outlet_id';

        $cart = [];

        foreach ($order->items as $item) {

            if (!$item->menu) {
                continue;
            }

            $cart[$item->menu_id] = [
                'name'     => $item->menu->name,
                'price'    => (float) $item->price_at_time,
                'quantity' => $item->quantity,
                'notes'    => $item->notes,
                'image'    => $item->menu->image,
            ];
        }

        session([
            $cartKey   => $cart,
            $outletKey => $order->outlet_id,
        ]);

        return redirect()->route(
            $order->type === 'delivery'
                ? 'delivery.cart'
                : 'dine-in.cart'
        )->with(
            'success',
            'Pesanan berhasil dimasukkan kembali ke keranjang.'
        );
    }
}