<x-guest-layout>
    <h2>Lupa Password</h2>

    <p class="text-sm text-muted mb-16">
        Masukkan email Anda dan kami akan mengirimkan link reset password.
    </p>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input id="email" class="form-input" type="email" name="email"
                   value="{{ old('email') }}" required autofocus>
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="d-flex justify-between align-center">
            <a href="{{ route('login') }}" class="text-sm text-muted">Kembali ke Login</a>
            <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
        </div>
    </form>
</x-guest-layout>
