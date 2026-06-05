<x-app-layout>
    <x-slot name="header">
        <h2>Profil Saya</h2>
    </x-slot>

    <div class="container-sm">

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
