<<<<<<< HEAD
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
=======
﻿@if(session('status') === 'profile-updated')
    <div class="alert alert-success mb-16">Profil berhasil diperbarui.</div>
@endif

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('patch')

    {{-- Avatar --}}
    <div class="form-group d-flex align-center gap-16">
        @if($user->avatar)
            <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="avatar">
        @else
            <div class="avatar d-flex align-center justify-center" style="background:#f0f0f0;color:#aaa;font-size:30px">?</div>
        @endif
        <div>
            <label class="form-label">Foto Profil</label>
            <input type="file" name="avatar" accept="image/*" class="form-input" style="padding:6px">
            <x-input-error :messages="$errors->get('avatar')" />
        </div>
    </div>

    <div class="form-group">
        <label class="form-label" for="name">Nama Lengkap</label>
        <input id="name" type="text" name="name" class="form-input"
               value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        <x-input-error :messages="$errors->get('name')" />
    </div>

    <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <input id="email" type="email" name="email" class="form-input"
               value="{{ old('email', $user->email) }}" required autocomplete="username">
        <x-input-error :messages="$errors->get('email')" />
    </div>

    <div class="form-group">
        <label class="form-label" for="phone_number">Nomor Telepon</label>
        <input id="phone_number" type="tel" name="phone_number" class="form-input"
               value="{{ old('phone_number', $user->phone_number) }}" autocomplete="tel">
        <x-input-error :messages="$errors->get('phone_number')" />
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
