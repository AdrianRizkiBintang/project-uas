<x-app-layout>
    <x-slot name="header">
        <h2>Pilih Alamat Pengiriman</h2>
    </x-slot>

    <div class="container-md">

        @if(session('success'))
            <div class="alert alert-success mt-16">
                {{ session('success') }}
            </div>
        @endif

        {{-- Saved Addresses --}}
        @if($addresses->isNotEmpty())
            <div class="card mb-20">
                <div class="card-header">Alamat Tersimpan</div>

                @foreach($addresses as $addr)
                    <div class="address-card {{ $addr->is_default ? 'is-default' : '' }}">
                        <div class="flex-1">

                            <div class="d-flex align-center gap-8 mb-4">
                                <span class="badge badge-blue">
                                    {{ $addr->label }}
                                </span>

                                @if($addr->is_default)
                                    <span class="badge badge-success">
                                        Utama
                                    </span>
                                @endif
                            </div>

                            <div class="address-text">
                                {{ $addr->address }}
                            </div>

                        </div>

                        <a href="{{ route('delivery.outlet', ['address_id' => $addr->id]) }}"
                           class="btn btn-blue btn-sm">
                            Pilih
                        </a>
                    </div>
                @endforeach

            </div>
        @else
            <div class="card mb-20">
                <div class="card-body text-center text-muted">
                    Belum ada alamat tersimpan.
                </div>
            </div>
        @endif

        {{-- Add New Address --}}
        <div class="card mb-20">
            <div class="card-header">
                Tambah Alamat Baru
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('addresses.store') }}">
                    @csrf

                    <div class="grid-2 mb-16">

                        <div class="form-group">
                            <label class="form-label">
                                Label
                            </label>

                            <input type="text"
                                   name="label"
                                   value="{{ old('label') }}"
                                   class="form-input"
                                   placeholder="Rumah / Kantor">

                            <x-input-error :messages="$errors->get('label')" />
                        </div>

                        <div class="form-group d-flex align-center" style="padding-top:24px">
                            <div class="form-check">
                                <input type="checkbox"
                                       id="is_default"
                                       name="is_default">

                                <label for="is_default">
                                    Jadikan alamat utama
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Alamat Lengkap
                        </label>

                        <textarea name="address"
                                  class="form-textarea"
                                  placeholder="Jl. Contoh No. 10, Kel. ..., Kec. ...">{{ old('address') }}</textarea>

                        <x-input-error :messages="$errors->get('address')" />
                    </div>

                    <button type="submit"
                            class="btn btn-blue btn-full">
                        Simpan Alamat
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>