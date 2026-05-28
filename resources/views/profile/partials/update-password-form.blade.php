@if(session('status') === 'password-updated')
    <div class="alert alert-success mb-16">Password berhasil diubah.</div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="form-group">
        <label class="form-label" for="current_password">Password Saat Ini</label>
        <input id="current_password" type="password" name="current_password" class="form-input"
               autocomplete="current-password">
        <x-input-error :messages="$errors->updatePassword->get('current_password')" />
    </div>

    <div class="form-group">
        <label class="form-label" for="new_password">Password Baru</label>
        <input id="new_password" type="password" name="password" class="form-input"
               autocomplete="new-password">
        <x-input-error :messages="$errors->updatePassword->get('password')" />
    </div>

    <div class="form-group">
        <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
        <input id="password_confirmation" type="password" name="password_confirmation" class="form-input"
               autocomplete="new-password">
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" />
    </div>

    <button type="submit" class="btn btn-primary">Ubah Password</button>
</form>
