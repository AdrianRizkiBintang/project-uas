<<<<<<< HEAD
<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
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
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
=======
﻿<x-guest-layout>
    <h2>Reset Password</h2>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input id="email" class="form-input" type="email" name="email"
                   value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password Baru</label>
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

        <button type="submit" class="btn btn-primary btn-full">Reset Password</button>
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
    </form>
</x-guest-layout>
