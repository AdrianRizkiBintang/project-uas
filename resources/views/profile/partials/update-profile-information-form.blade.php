@if(session('status') === 'profile-updated')
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
