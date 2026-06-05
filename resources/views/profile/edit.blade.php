<<<<<<< HEAD
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
=======
﻿<x-app-layout>
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

>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
    </div>
</x-app-layout>
