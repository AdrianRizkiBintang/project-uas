@extends('manager.layout')

@section('content')
<h1 class="text-2xl font-bold mb-6">Daftar Pesanan</h1>

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
            @forelse($orders as $order)
            <tr class="border-t">
                <td class="p-3">#{{ $order->id }}</td>
                <td class="p-3">{{ $order->user->name ?? '-' }}</td>
                <td class="p-3">{{ $order->type ?? '-' }}</td>
                <td class="p-3">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</td>
                <td class="p-3">
                    <span class="px-2 py-0.5 rounded text-xs
                        {{ $order->status === 'selesai' ? 'bg-green-100 text-green-700' :
                          ($order->status === 'diproses' ? 'bg-blue-100 text-blue-700' :
                          ($order->status === 'dikirim' ? 'bg-purple-100 text-purple-700' :
                          ($order->status === 'dibatalkan' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'))) }}">
                        {{ ucfirst($order->status ?? 'pending') }}
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