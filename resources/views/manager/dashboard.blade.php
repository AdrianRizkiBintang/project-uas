@extends('manager.layout')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl p-4 shadow-sm text-center">
        <p class="text-3xl font-bold text-orange-500">{{ $stats['total_menu'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Total Menu</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm text-center">
        <p class="text-3xl font-bold text-blue-500">{{ $stats['total_outlet'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Total Outlet</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm text-center">
        <p class="text-3xl font-bold text-green-500">{{ $stats['total_order'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Total Pesanan</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm text-center">
        <p class="text-3xl font-bold text-purple-500">{{ $stats['total_user'] }}</p>
        <p class="text-gray-500 text-sm mt-1">Total Customer</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm p-4">
    <h2 class="font-semibold text-lg mb-4">Pesanan Terbaru</h2>
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-2">ID</th>
                <th class="text-left p-2">Customer</th>
                <th class="text-left p-2">Tipe</th>
                <th class="text-left p-2">Total</th>
                <th class="text-left p-2">Status</th>
                <th class="text-left p-2">Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent_orders as $order)
            <tr class="border-t">
                <td class="p-2">#{{ $order->id }}</td>
                <td class="p-2">{{ $order->user->name ?? '-' }}</td>
                <td class="p-2">{{ $order->type ?? '-' }}</td>
                <td class="p-2">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</td>
                <td class="p-2">
                    <span class="px-2 py-0.5 rounded text-xs
                        {{ $order->status === 'selesai' ? 'bg-green-100 text-green-700' :
                          ($order->status === 'diproses' ? 'bg-blue-100 text-blue-700' :
                          ($order->status === 'dikirim' ? 'bg-purple-100 text-purple-700' :
                          ($order->status === 'dibatalkan' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'))) }}">
                        {{ ucfirst($order->status ?? 'pending') }}
                    </span>
                </td>
                <td class="p-2 text-gray-400">{{ $order->created_at->diffForHumans() }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="p-4 text-center text-gray-400">Belum ada pesanan</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection