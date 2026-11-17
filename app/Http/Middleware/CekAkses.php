<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekAkses
{
    public function handle(Request $request, Closure $next, string $modul, string $aksi = 'view'): Response
    {
        $user = $request->user();

        if (! $user || ! $user->bisa($modul, $aksi)) {
            abort(403, 'Anda tidak memiliki hak akses ke fitur ini.');
        }

        return $next($request);
    }
}