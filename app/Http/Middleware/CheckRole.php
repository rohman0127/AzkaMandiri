<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        if (isset($user->is_active) && !$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->with('error', 'Akun Anda dinonaktifkan oleh Administrator.');
        }

        if (method_exists($user, 'hasRole') && ($user->hasRole(['Super Admin', 'super-admin']) || $user->hasRole($roles))) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Role Anda tidak memiliki otoritas untuk mengakses fitur ini.',
            ], 403);
        }

        return redirect()->route('admin.dashboard')
            ->with('error', 'Akses Ditolak: Fitur ini dibatasi khusus untuk peran tertentu.');
    }
}

