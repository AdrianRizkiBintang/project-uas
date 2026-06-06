<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::latest()->paginate(10);
        return view('manager.outlet.index', compact('outlets'));
    }

    public function create()
    {
        return view('manager.outlet.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string',
            'status' => 'required|in:open,closed',
        ]);

        Outlet::create($request->only('name', 'location', 'status'));

        return redirect()->route('manager.outlet.index')->with('success', 'Outlet berhasil ditambahkan!');
    }

    public function edit(Outlet $outlet)
    {
        return view('manager.outlet.edit', compact('outlet'));
    }

    public function update(Request $request, Outlet $outlet)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string',
            'status'   => 'required|in:active,inactive',
        ]);

        $outlet->update($request->only('name', 'location', 'status'));

        return redirect()->route('manager.outlet.index')->with('success', 'Outlet berhasil diupdate!');
    }

    public function destroy(Outlet $outlet)
    {
        $outlet->delete();
        return redirect()->route('manager.outlet.index')->with('success', 'Outlet berhasil dihapus!');
    }
}