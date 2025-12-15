<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function loginPage()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Check Email
        $admin = Admin::where('email', $request->email)->first();

        // Invalid login
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->with('toast_error', 'Invalid login details!');
        }

        // Login admin
        Auth::guard('admin')->login($admin);

        // Redirect to dashboard with toast
        return redirect()
            ->route('admin.dashboard')
            ->with('toast_success', 'Login Successful!');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()
            ->route('admin.login')
            ->with('toast_success', 'Logged out successfully!');
    }

public function dashboard()
{
    $services = Service::all(); // all services
    $serviceCount  = Service::count();
    return view('admin.dashboard', compact('services', 'serviceCount'));
}


}
