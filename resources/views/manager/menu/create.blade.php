@extends('manager.layout')

@section('content')
<div class="max-w-xl">
    <h1 class="text-2xl font-bold mb-6">Tambah Menu Baru</h1>

    <form method="POST" action="{{ route('manager.menu.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm p-6 space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Nama Menu</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-3 py-2" required>
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Kategori</label>
            <select name="category" class="w-full border rounded-lg px-3 py-2" required>
                <option value="">-- Pilih --</option>
                <option value="makanan" {{ old('category') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="minuman" {{ old('category') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                <option value="snack" {{ old('category') == 'snack' ? 'selected' : '' }}>Snack</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
            <input type="number" name="price" value="{{ old('price') }}" class="w-full border rounded-lg px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Foto Menu</label>
            <input type="file" name="image" accept="image/*" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_available" value="1" id="avail" checked>
            <label for="avail" class="text-sm">Tersedia untuk dipesan</label>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600">Simpan</button>
            <a href="{{ route('manager.menu.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Batal</a>
        </div>
    </form>
</div>
@endsection