@extends('manager.layout')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Manajemen Outlet</h1>
    <a href="{{ route('manager.outlet.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600">+ Tambah Outlet</a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-3">Nama Outlet</th>
                <th class="text-left p-3">Lokasi</th>
                <th class="text-left p-3">Status</th>
                <th class="text-left p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($outlets as $outlet)
            <tr class="border-t">
                <td class="p-3 font-medium">{{ $outlet->name }}</td>
                <td class="p-3 text-gray-500">{{ $outlet->location }}</td>
                <td class="p-3">
                    <span class="px-2 py-0.5 rounded text-xs {{ $outlet->status == 'open' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $outlet->status == 'open' ? 'Buka' : 'Tutup' }}
                    </span>
                </td>
                <td class="p-3 flex gap-2">
                    <a href="{{ route('manager.outlet.edit', $outlet) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('manager.outlet.destroy', $outlet) }}" onsubmit="return confirm('Hapus outlet ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="p-4 text-center text-gray-400">Belum ada outlet</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3">{{ $outlets->links() }}</div>
</div>
@endsection