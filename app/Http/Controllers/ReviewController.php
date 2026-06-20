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
            'rating'      => 'required|integer|min:1|max:5',
            'comments'    => 'nullable|string|max:1000',
            'tip_amount'  => 'nullable|string',
            'custom_tip'  => 'nullable|integer|min:0|max:100000',
        ];

        if ($order->type === 'delivery') {
            $rules['courier_rating'] = 'required|integer|min:1|max:5';
        }

        $validated = $request->validate($rules);

        // Hitung tip
        $tipAmount = 0;

        if (($validated['tip_amount'] ?? '0') === 'custom') {
            $tipAmount = (int) ($request->custom_tip ?? 0);
        } else {
        $tipAmount = (int) ($validated['tip_amount'] ?? 0);
        }

        Review::create([
            'order_id'       => $order->id,
            'user_id'        => auth()->id(),
            'rating'         => $validated['rating'],
            'courier_rating' => $validated['courier_rating'] ?? null,
            'comments'       => $validated['comments'] ?? null,
        ]);

        // Simpan tip ke order
        $order->update([
            'tip_amount' => $tipAmount,
        ]);

        return redirect()
            ->route('profile.history')
            ->with('success', 'Ulasan berhasil dikirim.');
    }
}