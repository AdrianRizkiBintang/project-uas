<div class="alert alert-warning mb-16">
    Setelah akun dihapus, semua data akan dihapus secara permanen dan tidak dapat dipulihkan.
</div>

<details>
    <summary style="cursor:pointer;font-weight:600;color:#c62828;padding:10px 0;user-select:none">
        Hapus Akun Saya
    </summary>
    <div style="margin-top:16px;padding:16px;border:1px solid #e53935;border-radius:6px;background:#fff8f8">
        <p class="text-sm text-muted mb-16">
            Masukkan password untuk mengonfirmasi penghapusan akun.
        </p>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
            <div class="form-group">
                <label class="form-label" for="del_password">Password</label>
                <input id="del_password" type="password" name="password" class="form-input"
                       placeholder="Masukkan password Anda" required>
                <x-input-error :messages="$errors->userDeletion->get('password')" />
            </div>
            <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen?')">
                Ya, Hapus Akun Saya
            </button>
        </form>
    </div>
</details>
