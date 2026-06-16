<x-app-layout>
    <x-slot name="header">
        <h2>Wishlist Saya</h2>
    </x-slot>

    <div class="container">

        @if(session('success'))
            <div class="alert alert-success mt-16">{{ session('success') }}</div>
        @endif

        @if($wishlists->isEmpty())
            <div class="empty-state"><div class="empty-state-msg">Belum ada menu favorit. Tambahkan dari halaman menu.</div></div>
        @else
        <div class="menu-grid mb-20">
            @foreach($wishlists as $wishlist)
            @php $menu = $wishlist->menu; @endphp
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
                    <form method="POST" action="{{ route('wishlist.toggle', $menu) }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm flex-1">Hapus dari Wishlist</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</x-app-layout>