<<<<<<< HEAD
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
=======
﻿<x-guest-layout>
    <h2>Lupa Password</h2>

    <p class="text-sm text-muted mb-16">
        Masukkan email Anda dan kami akan mengirimkan link reset password.
    </p>

    <x-auth-session-status :status="session('status')" />
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

<<<<<<< HEAD
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
=======
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input id="email" class="form-input" type="email" name="email"
                   value="{{ old('email') }}" required autofocus>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="d-flex justify-between align-center">
            <a href="{{ route('login') }}" class="text-sm text-muted">Kembali ke Login</a>
            <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
        </div>
    </form>
</x-guest-layout>
