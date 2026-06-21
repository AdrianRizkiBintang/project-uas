<x-app-layout>
    <x-slot name="header">
        <h2>Profil Saya</h2>
    </x-slot>

    <div class="container-sm">

        {{-- Statistik Akun --}}
        <div class="profile-section mb-24">
            <div class="profile-section-header">
                Statistik Akun
            </div>

            <div class="profile-section-body">
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px">

                    <div class="card">
                        <div class="card-body text-center">
                            <div style="font-size:28px">📦</div>
                            <div style="font-size:24px;font-weight:700">
                                {{ $totalOrders }}
                            </div>
                            <div>Total Pesanan</div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body text-center">
                            <div style="font-size:28px">💰</div>
                            <div style="font-size:24px;font-weight:700">
                                Rp {{ number_format($totalSpent, 0, ',', '.') }}
                            </div>
                            <div>Total Pengeluaran</div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body text-center">
                            <div style="font-size:28px">⭐</div>
                            <div style="font-size:24px;font-weight:700">
                                {{ $totalReviews }}
                            </div>
                            <div>Total Review</div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body text-center">
                            <div style="font-size:28px">❤</div>
                            <div style="font-size:24px;font-weight:700">
                                {{ $totalWishlists }}
                            </div>
                            <div>Total Wishlist</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="profile-section mb-24">
            <div class="profile-section-header">Informasi Profil</div>
            <div class="profile-section-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="profile-section mb-24">
            <div class="profile-section-header">Ubah Password</div>
            <div class="profile-section-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="profile-section mb-24">
            <div class="profile-section-header" style="color:#c62828">Hapus Akun</div>
            <div class="profile-section-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</x-app-layout>

