<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->status === 'completed', 422);
        abort_if($order->review()->exists(), 422);

        $rules = [
            'rating'   => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
        ];

        if ($order->type === 'delivery') {
            $rules['courier_rating'] = 'required|integer|min:1|max:5';
        }

        $validated = $request->validate($rules);

        Review::create(array_merge($validated, [
            'order_id' => $order->id,
            'user_id'  => auth()->id(),
        ]));

        return redirect()->route('profile.history')->with('success', 'Ulasan berhasil dikirim.');
    }
}
