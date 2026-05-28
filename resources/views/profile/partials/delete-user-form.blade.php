<<<<<<< HEAD
<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
=======
﻿<div class="alert alert-warning mb-16">
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
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
