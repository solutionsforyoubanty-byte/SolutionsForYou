<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role = 'admin'): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login');
        }

        // Check if admin is active
        if (!$admin->is_active) {
            Auth::guard('admin')->logout();
            return redirect()
                ->route('admin.login')
                ->with('toast_error', 'Your account has been deactivated!');
        }

        // If role is 'admin', only allow admin role
        if ($role === 'admin' && !$admin->isAdmin()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('toast_error', 'You do not have permission to access this page!');
        }

        return $next($request);
    }
}
