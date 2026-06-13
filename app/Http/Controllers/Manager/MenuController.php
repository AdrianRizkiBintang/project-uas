<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Menampilkan daftar semua menu dengan pagination 10 item per halaman.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $menus = Menu::latest()->paginate(10);
        return view('manager.menu.index', compact('menus'));
    }

    /**
     * Menampilkan form untuk menambahkan menu baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manager.menu.create');
    }

    /**
     * Menyimpan data menu baru ke database.
     * Jika ada file gambar, disimpan ke storage public/menus.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari form tambah menu
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'category'     => 'required|string',
            'image'        => 'nullable|image|max:2048',
            'is_available' => 'boolean',
        ]);

        // Ambil semua data kecuali field image, lalu set ketersediaan menu
        $data = $request->except('image');
        $data['is_available'] = $request->boolean('is_available', true);

        // Simpan gambar ke storage jika ada file yang diupload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('manager.menu.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit untuk menu yang dipilih.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\View\View
     */
    public function edit(Menu $menu)
    {
        return view('manager.menu.edit', compact('menu'));
    }

    /**
     * Memperbarui data menu yang sudah ada di database.
     * Jika ada gambar baru diupload, gambar lama akan dihapus dari storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Menu $menu)
    {
        // Validasi input dari form edit menu
        $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'category'     => 'required|string',
            'image'        => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');
        $data['is_available'] = $request->boolean('is_available', true);

        // Jika ada gambar baru, hapus gambar lama lalu simpan yang baru
        if ($request->hasFile('image')) {
            if ($menu->image) Storage::disk('public')->delete($menu->image);
            $data['image'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('manager.menu.index')->with('success', 'Menu berhasil diupdate!');
    }

    /**
     * Menghapus menu dari database beserta gambarnya dari storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Menu $menu)
    {
        // Hapus file gambar dari storage jika ada
        if ($menu->image) Storage::disk('public')->delete($menu->image);

        $menu->delete();

        return redirect()->route('manager.menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}