<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        // 1. Account active check
        if (isset($user->is_active) && !$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->with('error', 'Akun Anda dinonaktifkan oleh Administrator. Silakan hubungi admin utama.');
        }

        // 2. Super Admin bypass
        if (method_exists($user, 'hasRole') && $user->hasRole(['Super Admin', 'super-admin'])) {
            return $next($request);
        }

        // 3. Check if user has any of the required permissions
        $hasAccess = false;
        foreach ($permissions as $permission) {
            if ($user->can($permission)) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Anda tidak memiliki hak akses (permission) untuk tindakan ini.',
                ], 403);
            }

            return redirect()->route('admin.dashboard')
                ->with('error', 'Akses Ditolak: Anda tidak memiliki izin untuk mengakses modul tersebut.');
        }

        return $next($request);
    }
}

