@extends('manager.layout')

@section('content')
<div class="max-w-xl">
    <h1 class="text-2xl font-bold mb-6">Tambah Outlet</h1>

    <form method="POST" action="{{ route('manager.outlet.store') }}" class="bg-white rounded-xl shadow-sm p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Nama Outlet</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Lokasi</label>
            <textarea name="location" rows="3" class="w-full border rounded-lg px-3 py-2" required>{{ old('location') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" class="w-full border rounded-lg px-3 py-2" required>
                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Buka</option>
                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Tutup</option>
            </select>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600">Simpan</button>
            <a href="{{ route('manager.outlet.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection