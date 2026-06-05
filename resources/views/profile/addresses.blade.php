<x-app-layout>
    <x-slot name="header">
        <h2>Alamat Tersimpan</h2>
    </x-slot>

    <div class="container-sm">

        @if(session('success'))
            <div class="alert alert-success mt-16">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger mt-16">
                @foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach
            </div>
        @endif

        {{-- Existing Addresses --}}
        @if($addresses->isEmpty())
            <div class="card mb-20">
                <div class="card-body text-center text-muted">Belum ada alamat tersimpan.</div>
            </div>
        @else
        <div class="card mb-20">
            <div class="card-header">Daftar Alamat</div>
            @foreach($addresses as $addr)
            <div class="address-card {{ $addr->is_default ? 'is-default' : '' }}">
                <div class="flex-1">
                    <div class="d-flex align-center gap-8 mb-4">
                        <span class="badge badge-blue">{{ $addr->label }}</span>
                        @if($addr->is_default)
                            <span class="badge badge-success">Utama</span>
                        @endif
                    </div>
                    <div class="address-text">{{ $addr->address }}</div>
                    @if($addr->latitude && $addr->longitude)
                    <div class="text-sm text-muted mt-4">
                        GPS: {{ $addr->latitude }}, {{ $addr->longitude }}
                    </div>
                    @endif
                </div>
                <div class="address-actions">
                    @unless($addr->is_default)
                    <form method="POST" action="{{ route('addresses.default', $addr) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-outline-blue btn-sm">Jadikan Utama</button>
                    </form>
                    @endunless
                    <form method="POST" action="{{ route('addresses.destroy', $addr) }}"
                          onsubmit="return confirm('Hapus alamat ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Add New --}}
        <div class="card mb-20">
            <div class="card-header">Tambah Alamat Baru</div>
            <div class="card-body">
                <form method="POST" action="{{ route('addresses.store') }}">
                    @csrf
                    <div class="grid-2 mb-16">
                        <div class="form-group">
                            <label class="form-label">Label</label>
                            <input type="text" name="label" value="{{ old('label') }}"
                                   class="form-input" placeholder="Rumah / Kantor">
                            <x-input-error :messages="$errors->get('label')" />
                        </div>
                        <div class="form-group d-flex align-center" style="padding-top:22px">
                            <div class="form-check">
                                <input type="checkbox" id="is_default_new" name="is_default">
                                <label for="is_default_new">Jadikan alamat utama</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="address" class="form-textarea"
                                  placeholder="Jl. Contoh No. 10, Kelurahan, Kecamatan, Kota">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" />
                    </div>
                    <div class="grid-2 mb-16">
                        <div class="form-group">
                            <label class="form-label">Latitude (opsional)</label>
                            <input type="number" step="any" name="latitude" value="{{ old('latitude') }}"
                                   class="form-input" placeholder="-6.123456">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Longitude (opsional)</label>
                            <input type="number" step="any" name="longitude" value="{{ old('longitude') }}"
                                   class="form-input" placeholder="106.123456">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-blue btn-full">Simpan Alamat</button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>     