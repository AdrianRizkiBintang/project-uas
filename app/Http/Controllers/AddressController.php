<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses;
        return view('profile.addresses', compact('addresses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'     => 'required|string|max:50',
            'address'   => 'required|string|max:500',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($request->boolean('is_default')) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        auth()->user()->addresses()->create(array_merge($validated, [
            'is_default' => $request->boolean('is_default'),
        ]));

        return redirect()->route('addresses.index')->with('success', 'Alamat berhasil ditambahkan.');
    }

    public function destroy(UserAddress $address)
    {
        abort_unless($address->user_id === auth()->id(), 403);
        $address->delete();

        return redirect()->route('addresses.index')->with('success', 'Alamat dihapus.');
    }

    public function setDefault(UserAddress $address)
    {
        abort_unless($address->user_id === auth()->id(), 403);
        auth()->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return redirect()->route('addresses.index')->with('success', 'Alamat utama diperbarui.');
    }
}
