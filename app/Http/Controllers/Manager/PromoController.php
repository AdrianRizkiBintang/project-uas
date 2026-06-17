<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::latest()->paginate(10);
        return view('manager.promo.index', compact('promos'));
    }

    public function create()
    {
        return view('manager.promo.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'code'            => 'required|string|max:50|unique:promos,code',
        'discount_type'   => 'required|in:percentage,fixed',
        'discount_value'  => 'required|numeric|min:0',
        'min_order'       => 'nullable|numeric|min:0',
        'max_uses'        => 'nullable|integer|min:1',
        'expiration_date' => 'nullable|date',
        'is_active'       => 'nullable',
    ]);

    $validated['is_active'] = $request->has('is_active');
    $validated['used_count'] = 0;

    Promo::create($validated);

    return redirect()->route('manager.promo.index')
        ->with('success', 'Promo berhasil ditambahkan.');
}

    public function edit(Promo $promo)
    {
        return view('manager.promo.edit', compact('promo'));
    }

    public function update(Request $request, Promo $promo)
{
    $validated = $request->validate([
        'code'            => 'required|string|max:50|unique:promos,code,' . $promo->id,
        'discount_type'   => 'required|in:percentage,fixed',
        'discount_value'  => 'required|numeric|min:0',
        'min_order'       => 'nullable|numeric|min:0',
        'max_uses'        => 'nullable|integer|min:1',
        'expiration_date' => 'nullable|date',
        'is_active'       => 'nullable',
    ]);

    $validated['is_active'] = $request->has('is_active');

    $promo->update($validated);

    return redirect()->route('manager.promo.index')
        ->with('success', 'Promo berhasil diperbarui.');
}

    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()->route('manager.promo.index')->with('success', 'Promo berhasil dihapus.');
    }
}