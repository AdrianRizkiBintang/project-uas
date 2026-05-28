<x-guest-layout>
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
        </div>
    </form>
</x-guest-layout>
