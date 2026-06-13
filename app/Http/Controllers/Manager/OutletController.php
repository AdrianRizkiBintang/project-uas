<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    /**
     * Menampilkan daftar semua outlet dengan pagination 10 item per halaman.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $outlets = Outlet::latest()->paginate(10);
        return view('manager.outlet.index', compact('outlets'));
    }

    /**
     * Menampilkan form untuk menambahkan outlet baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.outlet.create');
    }

    /**
     * Menyimpan data outlet baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input form tambah outlet
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string',
            'status'   => 'required|in:open,closed',
        ]);

        Outlet::create($request->only('name', 'location', 'status'));

        return redirect()->route('manager.outlet.index')->with('success', 'Outlet berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit untuk outlet yang dipilih.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\View\View
     */
    public function edit(Outlet $outlet)
    {
        return view('manager.outlet.edit', compact('outlet'));
    }

    /**
     * Memperbarui data outlet yang sudah ada di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Outlet $outlet)
    {
        // Validasi input form edit outlet
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string',
            'status'   => 'required|in:active,inactive',
        ]);

        $outlet->update($request->only('name', 'location', 'status'));

        return redirect()->route('manager.outlet.index')->with('success', 'Outlet berhasil diupdate!');
    }

    /**
     * Menghapus outlet dari database.
     *
     * @param  \App\Models\Outlet  $outlet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Outlet $outlet)
    {
        $outlet->delete();
        return redirect()->route('manager.outlet.index')->with('success', 'Outlet berhasil dihapus!');
    }
}