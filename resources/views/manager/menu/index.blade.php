@extends('manager.layout')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Manajemen Menu</h1>
    <a href="{{ route('manager.menu.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">+ Tambah Menu</a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-3">Gambar</th>
                <th class="text-left p-3">Nama</th>
                <th class="text-left p-3">Kategori</th>
                <th class="text-left p-3">Harga</th>
                <th class="text-left p-3">Status</th>
                <th class="text-left p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menus as $menu)
            <tr class="border-t">
                <td class="p-3">
                    @if($menu->image)
                        <img src="{{ Storage::url($menu->image) }}" class="w-12 h-12 object-cover rounded">
                    @else
                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">No img</div>
                    @endif
                </td>
                <td class="p-3 font-medium">{{ $menu->name }}</td>
                <td class="p-3 text-gray-500">{{ $menu->category }}</td>
                <td class="p-3">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                <td class="p-3">
                    <span class="px-2 py-0.5 rounded text-xs {{ $menu->is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                    </span>
                </td>
                <td class="p-3 flex gap-2">
                    <a href="{{ route('manager.menu.edit', $menu) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('manager.menu.destroy', $menu) }}" onsubmit="return confirm('Hapus menu ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="p-4 text-center text-gray-400">Belum ada menu</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3">{{ $menus->links() }}</div>
</div>
@endsection