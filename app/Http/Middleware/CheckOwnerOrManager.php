<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOwnerOrManager
{
    public function handle(Request $request, Closure $next): mixed
    {
        $role = $request->user()?->role;

        if (!in_array($role, ['owner', 'manager'])) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}