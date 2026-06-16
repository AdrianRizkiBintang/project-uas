<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $authRole = auth()->user()->role;

        // Owner lihat semua kecuali dirinya sendiri
        // Manager lihat hanya karyawan & customer
        if ($authRole === 'owner') {
            $users = User::where('id', '!=', auth()->id())->orderBy('role')->get();
        } else {
            // manager hanya bisa lihat karyawan & customer
            $users = User::whereIn('role', ['karyawan', 'customer'])
                         ->orderBy('role')
                         ->get();
        }

        return view('manager.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $authRole = auth()->user()->role;

        // Jangan bisa ubah diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah role diri sendiri.');
        }

        // Owner bisa set role apa saja kecuali owner lain
        if ($authRole === 'owner') {
            $allowed = ['customer', 'karyawan', 'manager'];
        } else {
            // Manager hanya bisa set karyawan atau customer
            $allowed = ['customer', 'karyawan'];
            // Manager tidak boleh mengubah role manager atau owner
            if (in_array($user->role, ['manager', 'owner'])) {
                abort(403, 'Tidak bisa mengubah role manager atau owner.');
            }
        }

        $request->validate([
            'role' => ['required', 'in:' . implode(',', $allowed)],
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', "Role {$user->name} diperbarui menjadi {$request->role}.");
    }
}