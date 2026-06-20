<x-app-layout>
    <x-slot name="header">
        <h2>Selamat Datang, {{ auth()->user()->name }}!</h2>
    </x-slot>

    <div class="container">

        @if(session('success'))
            <div class="alert alert-success mt-16">{{ session('success') }}</div>
        @endif

        {{-- Pilih Jenis Order --}}
        <div class="card mb-20">
            <div class="card-header">Mau makan dimana?</div>
            <div class="card-body">
                <div class="grid-2">
                    <div class="order-type-card dinein">
                        <div class="order-type-title">Dine In</div>
                        <div class="order-type-sub">Makan di tempat, pilih outlet favorit Anda</div>
                        <a href="{{ route('home') }}#pilih-outlet-dine" class="btn btn-primary btn-sm mt-8">
                            Pesan Sekarang
                        </a>
                    </div>
                    <div class="order-type-card delivery">
                        <div class="order-type-title">Delivery</div>
                        <div class="order-type-sub">Antar ke alamat Anda</div>
                        <a href="{{ route('delivery.address') }}" class="btn btn-blue btn-sm mt-8">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Promo Aktif --}}
        @if($promos->isNotEmpty())
        <div class="card mb-20">
            <div class="card-header">Promo Aktif</div>
            <div class="card-body">
                <div class="grid-3">
                    @foreach($promos as $promo)
                    <div class="promo-card">
                        <div class="text-sm font-bold" style="opacity:.8;letter-spacing:1px;text-transform:uppercase">Kode Promo</div>
                        <div class="promo-code">{{ $promo->code }}</div>
                        <div class="promo-discount">
                            Diskon
                            @if($promo->discount_type === 'percentage')
                                {{ $promo->discount_value }}%
                            @else
                                Rp {{ number_format($promo->discount_value, 0, ',', '.') }}
                            @endif
                        </div>
                        @if($promo->minimum_order)
                        <div class="promo-min">Min. order Rp {{ number_format($promo->minimum_order, 0, ',', '.') }}</div>
                        @endif
                        @if($promo->expiration_date)
                        <div class="promo-expire">Berlaku hingga {{ $promo->expiration_date->format('d M Y') }}</div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Menu Terlaris --}}
        @if($bestSellers->isNotEmpty())
        <div class="card mb-20">
            <div class="card-header">🔥 Menu Terlaris</div>
            <div class="card-body">
                <div class="grid-3">
                    @foreach($bestSellers as $menu)
                    <div class="menu-card">
                        @if($menu->image)
                            <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="menu-card-img">
                        @else
                            <div class="menu-card-img-placeholder">Tidak ada gambar</div>
                        @endif
                        <div class="menu-card-body">
                            <div class="menu-card-cat">{{ ucfirst($menu->category) }}</div>
                            <div class="menu-card-name">{{ $menu->name }}</div>
                            <div class="menu-card-desc">{{ $menu->outlet->name ?? '-' }}</div>
                            <div class="menu-card-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Pilih Outlet Dine In --}}
        @if($outlets->isNotEmpty())
        <div id="pilih-outlet-dine" class="card mb-20">
            <div class="card-header">Pilih Outlet (Dine In)</div>
            <div class="card-body">
                <div class="grid-3">
                    @foreach($outlets as $outlet)
                    <div class="outlet-card">
                        <div class="outlet-name">{{ $outlet->name }}</div>
                        <div class="outlet-location">{{ $outlet->location }}</div>
                        <div class="outlet-status {{ $outlet->status === 'open' ? 'open' : 'closed' }}">
                            {{ $outlet->status === 'open' ? 'Buka' : 'Tutup' }}
                        </div>
                        @if($outlet->status === 'open')
                        <a href="{{ route('dine-in.menu', ['outlet_id' => $outlet->id]) }}"
                           class="btn btn-primary btn-sm mt-8">
                            Lihat Menu
                        </a>
                        @else
                        <span class="badge badge-secondary mt-8">Sedang Tutup</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="card mb-20">
            <div class="card-body text-center text-muted">Belum ada outlet yang tersedia saat ini.</div>
        </div>
        @endif

        

    </div>
</x-app-layout>
