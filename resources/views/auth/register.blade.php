<x-guest-layout>
    <h2>Masuk</h2>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input id="email" class="form-input" type="email" name="email"
                   value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input id="password" class="form-input" type="password" name="password"
                   required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="form-check mb-16">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Ingat saya</label>
        </div>

        <div class="d-flex justify-between align-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-muted">Lupa password?</a>
            @endif
            <button type="submit" class="btn btn-primary">Masuk</button>
        </div>

        <div class="text-center mt-16">
            <span class="text-sm text-muted">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="text-sm">Daftar</a>
        </div>
    </form>
</x-guest-layout>
