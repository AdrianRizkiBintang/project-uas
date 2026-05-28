<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-between align-center">
            <h2>Menu Delivery &mdash; {{ $outlet->name }}</h2>
            @php $cartCount = array_sum(array_column(session('delivery_cart', []), 'quantity')); @endphp
            <a href="{{ route('delivery.cart') }}" class="btn btn-blue btn-sm">
                Keranjang
                @if($cartCount > 0)
                    <span class="badge badge-secondary" style="margin-left:6px">{{ $cartCount }}</span>
                @endif
            </a>
        </div>
    </x-slot>

    <div class="container">

        @if(session('success'))
            <div class="alert alert-success mt-16">{{ session('success') }}</div>
        @endif

        {{-- Search & Filter --}}
        <div class="card mb-20">
            <div class="card-body">
                <form method="GET" action="{{ route('delivery.menu') }}" class="d-flex flex-wrap gap-8">
                    <input type="hidden" name="outlet_id" value="{{ $outlet->id }}">
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari menu..." class="form-input flex-1">
                    <select name="category" class="form-select" style="width:180px">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" @selected($category === $cat)>{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-blue">Cari</button>
                </form>
            </div>
        </div>

        {{-- Menu Grid --}}
        @if($menus->isEmpty())
            <div class="empty-state"><div class="empty-state-msg">Tidak ada menu yang ditemukan.</div></div>
        @else
        <div class="menu-grid mb-20">
            @foreach($menus as $menu)
            <div class="menu-card">
                @if($menu->image)
                    <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="menu-card-img">
                @else
                    <div class="menu-card-img-placeholder">Tidak ada gambar</div>
                @endif
                <div class="menu-card-body">
                    <div class="menu-card-cat">{{ ucfirst($menu->category) }}</div>
                    <div class="menu-card-name">{{ $menu->name }}</div>
                    @if($menu->description)
                        <div class="menu-card-desc">{{ Str::limit($menu->description, 60) }}</div>
                    @endif
                    <div class="menu-card-price" style="color:#1976d2">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                    <form method="POST" action="{{ route('cart.add') }}" class="menu-add-form">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <input type="hidden" name="outlet_id" value="{{ $outlet->id }}">
                        <input type="hidden" name="order_type" value="delivery">
                        <input type="number" name="quantity" value="1" min="1" class="qty-input">
                        <button type="submit" class="btn btn-blue btn-sm flex-1">+ Tambah</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</x-app-layout>
