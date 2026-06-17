@if ($errors->any())
    <div style="background:red;color:white;padding:10px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@extends('manager.layout')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Promo</h1>

<div class="bg-white rounded-xl shadow-sm p-6 max-w-lg">
    <form method="POST" action="{{ route('manager.promo.update', $promo) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Kode Promo</label>
            <input type="text" name="code" value="{{ old('code', $promo->code) }}" class="w-full border rounded-lg px-3 py-2 text-sm" required>
            @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Tipe Diskon</label>
            <select name="discount_type" class="w-full border rounded-lg px-3 py-2 text-sm" required>
                <option value="percentage" {{ old('discount_type', $promo->discount_type) == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                <option value="fixed" {{ old('discount_type', $promo->discount_type) == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nilai Diskon</label>
            <input type="number" step="0.01" name="discount_value" value="{{ old('discount_value', $promo->discount_value) }}" class="w-full border rounded-lg px-3 py-2 text-sm" required>
            @error('discount_value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Minimum Order (opsional)</label>
            <input type="number" step="0.01" name="min_order" value="{{ old('min_order', $promo->min_order) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Maksimal Penggunaan (opsional)</label>
            <input type="number" name="max_uses" value="{{ old('max_uses', $promo->max_uses) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Tanggal Expired (opsional)</label>
            <input type="date" name="expiration_date" value="{{ old('expiration_date', $promo->expiration_date?->format('Y-m-d')) }}" class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>

        <div class="mb-4 flex items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" {{ $promo->is_active ? 'checked' : '' }} class="rounded">
            <label for="is_active" class="text-sm">Aktifkan promo</label>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600">Update</button>
            <a href="{{ route('manager.promo.index') }}" class="border px-4 py-2 rounded-lg text-sm hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection