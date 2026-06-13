@extends('manager.layout')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Manajemen User</h1>
</div>

@php
    $authRole = auth()->user()->role;
    // Role yang bisa dipilih sesuai role yang login
    $roleOptions = $authRole === 'owner'
        ? ['customer', 'karyawan', 'manager']
        : ['customer', 'karyawan'];
@endphp

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="text-left p-3">Nama</th>
                <th class="text-left p-3">Email</th>
                <th class="text-left p-3">No. HP</th>
                <th class="text-left p-3">Role Saat Ini</th>
                <th class="text-left p-3">Ubah Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-t hover:bg-gray-50">
                <td class="p-3 font-medium">{{ $user->name }}</td>
                <td class="p-3 text-gray-500">{{ $user->email }}</td>
                <td class="p-3 text-gray-500">{{ $user->phone_number ?? '-' }}</td>
                <td class="p-3">
                    @php
                        $badgeColor = match($user->role) {
                            'owner'    => 'bg-red-100 text-red-700',
                            'manager'  => 'bg-purple-100 text-purple-700',
                            'karyawan' => 'bg-blue-100 text-blue-700',
                            default    => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $badgeColor }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="p-3">
                    {{-- Manager tidak bisa ubah role manager/owner --}}
                    @if($authRole === 'manager' && in_array($user->role, ['manager', 'owner']))
                        <span class="text-gray-400 text-xs italic">Tidak bisa diubah</span>
                    @else
                        <form method="POST"
                              action="{{ route('manager.user.role', $user) }}"
                              class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="role"
                                    class="border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                                @foreach($roleOptions as $option)
                                    <option value="{{ $option }}"
                                            {{ $user->role === $option ? 'selected' : '' }}>
                                        {{ ucfirst($option) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                    class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-sm transition">
                                Simpan
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-6 text-center text-gray-400">Belum ada user.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection