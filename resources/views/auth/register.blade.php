<<<<<<< HEAD
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
=======
﻿<x-guest-layout>
    <h2>Daftar Akun</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap</label>
            <input id="name" class="form-input" type="text" name="name"
                   value="{{ old('name') }}" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input id="email" class="form-input" type="email" name="email"
                   value="{{ old('email') }}" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="form-group">
            <label class="form-label" for="phone_number">Nomor Telepon</label>
            <input id="phone_number" class="form-input" type="text" name="phone_number"
                   value="{{ old('phone_number') }}" autocomplete="tel">
            <x-input-error :messages="$errors->get('phone_number')" />
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input id="password" class="form-input" type="password" name="password"
                   required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" class="form-input" type="password"
                   name="password_confirmation" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <button type="submit" class="btn btn-primary btn-full">Daftar</button>

        <div class="text-center mt-16">
            <span class="text-sm text-muted">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-sm">Masuk</a>
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
        </div>
    </form>
</x-guest-layout>
