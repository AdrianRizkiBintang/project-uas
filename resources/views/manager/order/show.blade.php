@extends('manager.layout')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Detail Pesanan #{{ $order->id }}</h1>
        <a href="{{ route('manager.order.index') }}" class="text-gray-500 hover:underline">← Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
            <div><span class="text-gray-500">Customer:</span> <strong>{{ $order->user->name ?? '-' }}</strong></div>
            <div><span class="text-gray-500">Tipe:</span> <strong>{{ $order->type ?? '-' }}</strong></div>
            <div><span class="text-gray-500">Status:</span>
                <span class="px-2 py-0.5 rounded text-xs
                    {{ $order->status === 'selesai' ? 'bg-green-100 text-green-700' :
                      ($order->status === 'diproses' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ $order->status ?? 'pending' }}
                </span>
            </div>
            <div><span class="text-gray-500">Waktu:</span> {{ $order->created_at->format('d M Y H:i') }}</div>
        </div>

        <h2 class="font-semibold mb-2">Item Pesanan</h2>
        <table class="w-full text-sm border rounded">
            <thead class="bg-gray-50"><tr>
                <th class="text-left p-2">Menu</th>
                <th class="text-left p-2">Qty</th>
                <th class="text-left p-2">Harga</th>
                <th class="text-left p-2">Subtotal</th>
            </tr></thead>
            <tbody>
                @foreach($order->items as $item)
                <tr class="border-t">
                    <td class="p-2">{{ $item->menu->name ?? $item->menu_name ?? '-' }}</td>
                    <td class="p-2">{{ $item->quantity }}</td>
                    <td class="p-2">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="p-2">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p class="text-right font-bold mt-3">Total: Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</p>
    </div>

    @if(auth()->user()->isStaff())
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h2 class="font-semibold mb-3">Update Status</h2>
        <div class="flex gap-3 flex-wrap">
            @foreach(['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'] as $s)
            <form method="POST" action="{{ route('manager.order.status', [$order, $s]) }}">
                @csrf @method('PATCH')
                <button class="px-4 py-1.5 rounded border text-sm
                    {{ $order->status === $s ? 'bg-gray-900 text-white' : 'hover:bg-gray-50' }}">
                    {{ ucfirst($s) }}
                </button>
            </form>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection