@extends('manager.layout')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Manajemen Promo</h1>
    <a href="{{ route('manager.promo.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600">
        + Tambah Promo
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-3">Kode</th>
                <th class="text-left p-3">Tipe</th>
                <th class="text-left p-3">Nilai</th>
                <th class="text-left p-3">Min. Order</th>
                <th class="text-left p-3">Penggunaan</th>
                <th class="text-left p-3">Expired</th>
                <th class="text-left p-3">Status</th>
                <th class="text-left p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($promos as $promo)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-3 font-semibold">{{ $promo->code }}</td>
                <td class="p-3">{{ $promo->discount_type === 'percentage' ? 'Persen' : 'Nominal' }}</td>
                <td class="p-3">
                    {{ $promo->discount_type === 'percentage' ? $promo->discount_value . '%' : 'Rp ' . number_format($promo->discount_value, 0, ',', '.') }}
                </td>
                <td class="p-3">{{ $promo->min_order ? 'Rp ' . number_format($promo->min_order, 0, ',', '.') : '-' }}</td>
                <td class="p-3">{{ $promo->used_count }} / {{ $promo->max_uses ?? '∞' }}</td>
                <td class="p-3">{{ $promo->expiration_date ? $promo->expiration_date->format('d M Y') : '-' }}</td>
                <td class="p-3">
                    <span class="px-2 py-0.5 rounded text-xs {{ $promo->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $promo->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="p-3">
                    <a href="{{ route('manager.promo.edit', $promo) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                    <form method="POST" action="{{ route('manager.promo.destroy', $promo) }}" class="inline" onsubmit="return confirm('Hapus promo ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="p-4 text-center text-gray-400">Belum ada promo</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3">{{ $promos->links() }}</div>
</div>
@endsection