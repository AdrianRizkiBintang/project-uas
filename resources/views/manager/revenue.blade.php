@extends('manager.layout')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    📈 Pendapatan Harian
</h1>

<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <p class="text-gray-500 text-sm">Total Pendapatan</p>

    <h2 class="text-4xl font-bold text-green-600 mt-2">
        Rp {{ number_format($dailyRevenue->sum('revenue'), 0, ',', '.') }}
    </h2>
</div>

<div class="bg-white rounded-xl shadow-sm p-4">
    <h2 class="font-semibold text-lg mb-4">
        Laporan Pendapatan per Hari
    </h2>

    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left p-3">Tanggal</th>
                <th class="text-center p-3">Jumlah Pesanan</th>
                <th class="text-right p-3">Pendapatan</th>
            </tr>
        </thead>

        <tbody>
            @foreach($dailyRevenue as $row)
            <tr class="border-t">
                <td class="p-3">
                    {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                </td>

                <td class="p-3 text-center">
                    {{ $row->total_orders }}
                </td>

                <td class="p-3 text-right font-semibold text-green-600">
                    Rp {{ number_format($row->revenue, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection