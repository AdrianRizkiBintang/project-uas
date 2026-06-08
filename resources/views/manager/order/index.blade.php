@extends('manager.layout')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Daftar Pesanan</h1>
    <span class="text-sm text-gray-500">{{ $orders->total() }} total pesanan</span>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('manager.order.index') }}" class="bg-white rounded-xl shadow-sm p-4 mb-4">
    <div class="flex gap-3 flex-wrap items-end">
        <div>
            <label class="block text-xs text-gray-500 mb-1">Status</label>
            <select name="status" class="border rounded-lg px-3 py-1.5 text-sm">
                <option value="">Semua Status</option>
                <option value="pending"          {{ request('status') == 'pending'          ? 'selected' : '' }}>Pending</option>
                <option value="confirmed"        {{ request('status') == 'confirmed'        ? 'selected' : '' }}>Dikonfirmasi</option>
                <option value="processing"       {{ request('status') == 'processing'       ? 'selected' : '' }}>Diproses</option>
                <option value="out_for_delivery" {{ request('status') == 'out_for_delivery' ? 'selected' : '' }}>Dikirim</option>
                <option value="completed"        {{ request('status') == 'completed'        ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled"        {{ request('status') == 'cancelled'        ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Tipe</label>
            <select name="type" class="border rounded-lg px-3 py-1.5 text-sm">
                <option value="">Semua Tipe</option>
                <option value="dine_in"  {{ request('type') == 'dine_in'  ? 'selected' : '' }}>Dine In</option>
                <option value="delivery" {{ request('type') == 'delivery' ? 'selected' : '' }}>Delivery</option>
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Tanggal</label>
            <input type="date" name="date" value="{{ request('date') }}" class="border rounded-lg px-3 py-1.5 text-sm">
        </div>
        <button type="submit" class="bg-orange-500 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-orange-600">
            Filter
        </button>
        @if(request()->anyFilled(['status', 'type', 'date']))
        <a href="{{ route('manager.order.index') }}" class="border px-4 py-1.5 rounded-lg text-sm hover:bg-gray-50 text-gray-600">
            Reset
        </a>
        @endif
    </div>
</form>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-3">ID</th>
                <th class="text-left p-3">Customer</th>
                <th class="text-left p-3">Tipe</th>
                <th class="text-left p-3">Total</th>
                <th class="text-left p-3">Status</th>
                <th class="text-left p-3">Waktu</th>
                <th class="text-left p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $statusLabel = [
                'pending'          => 'Pending',
                'confirmed'        => 'Dikonfirmasi',
                'processing'       => 'Diproses',
                'out_for_delivery' => 'Dikirim',
                'completed'        => 'Selesai',
                'cancelled'        => 'Dibatalkan',
            ];
            $statusColor = [
                'pending'          => 'bg-yellow-100 text-yellow-700',
                'confirmed'        => 'bg-blue-100 text-blue-700',
                'processing'       => 'bg-blue-100 text-blue-700',
                'out_for_delivery' => 'bg-purple-100 text-purple-700',
                'completed'        => 'bg-green-100 text-green-700',
                'cancelled'        => 'bg-red-100 text-red-700',
            ];
            @endphp
            @forelse($orders as $order)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-3">#{{ $order->id }}</td>
                <td class="p-3">{{ $order->user->name ?? '-' }}</td>
                <td class="p-3">{{ $order->type == 'dine_in' ? 'Dine In' : 'Delivery' }}</td>
                <td class="p-3">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</td>
                <td class="p-3">
                    <span class="px-2 py-0.5 rounded text-xs {{ $statusColor[$order->status] ?? 'bg-yellow-100 text-yellow-700' }}">
                        {{ $statusLabel[$order->status] ?? $order->status }}
                    </span>
                </td>
                <td class="p-3 text-gray-400">{{ $order->created_at->diffForHumans() }}</td>
                <td class="p-3">
                    <a href="{{ route('manager.order.show', $order) }}" class="text-blue-600 hover:underline">Detail</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="p-4 text-center text-gray-400">Belum ada pesanan</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-3">{{ $orders->links() }}</div>
</div>
@endsection