<x-guest-layout>
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
    </form>
</x-guest-layout>
