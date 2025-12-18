<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of admins
     */
    public function index()
    {
        $admins = Admin::latest()->paginate(15);
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,co-admin',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'is_active' => $request->has('is_active'),
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        Admin::create($data);

        return redirect()
            ->route('admin.admins.index')
            ->with('toast_success', 'Admin created successfully!');
    }

    /**
     * Show the form for editing an admin
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        
        // Prevent co-admin from editing admin
        if (Auth::guard('admin')->user()->isCoAdmin() && $admin->isAdmin()) {
            return redirect()
                ->route('admin.admins.index')
                ->with('toast_error', 'You cannot edit an Admin account!');
        }

        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        // Prevent co-admin from editing admin
        if (Auth::guard('admin')->user()->isCoAdmin() && $admin->isAdmin()) {
            return redirect()
                ->route('admin.admins.index')
                ->with('toast_error', 'You cannot edit an Admin account!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($admin->id)],
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:admin,co-admin',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'is_active' => $request->has('is_active'),
        ];

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($admin->avatar) {
                Storage::disk('public')->delete($admin->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $admin->update($data);

        return redirect()
            ->route('admin.admins.index')
            ->with('toast_success', 'Admin updated successfully!');
    }

    /**
     * Remove the specified admin
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        // Prevent deleting yourself
        if ($admin->id === Auth::guard('admin')->user()->id) {
            return redirect()
                ->route('admin.admins.index')
                ->with('toast_error', 'You cannot delete your own account!');
        }

        // Prevent co-admin from deleting admin
        if (Auth::guard('admin')->user()->isCoAdmin() && $admin->isAdmin()) {
            return redirect()
                ->route('admin.admins.index')
                ->with('toast_error', 'You cannot delete an Admin account!');
        }

        // Delete avatar
        if ($admin->avatar) {
            Storage::disk('public')->delete($admin->avatar);
        }

        $admin->delete();

        return redirect()
            ->route('admin.admins.index')
            ->with('toast_success', 'Admin deleted successfully!');
    }

    /**
     * Toggle admin status
     */
    public function toggleStatus($id)
    {
        $admin = Admin::findOrFail($id);

        // Prevent toggling yourself
        if ($admin->id === Auth::guard('admin')->user()->id) {
            return redirect()
                ->route('admin.admins.index')
                ->with('toast_error', 'You cannot deactivate your own account!');
        }

        // Prevent co-admin from toggling admin
        if (Auth::guard('admin')->user()->isCoAdmin() && $admin->isAdmin()) {
            return redirect()
                ->route('admin.admins.index')
                ->with('toast_error', 'You cannot modify an Admin account!');
        }

        $admin->update(['is_active' => !$admin->is_active]);

        $status = $admin->is_active ? 'activated' : 'deactivated';
        return redirect()
            ->route('admin.admins.index')
            ->with('toast_success', "Admin {$status} successfully!");
    }

    /**
     * Show profile page
     */
    public function profile()
    {
        $admin = Admin::find(Auth::guard('admin')->id());
        return view('admin.admins.profile', compact('admin'));
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $admin = Admin::find(Auth::guard('admin')->id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($admin->id)],
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($admin->avatar) {
                Storage::disk('public')->delete($admin->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Update password if provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->with('toast_error', 'Current password is incorrect!');
            }
            $data['password'] = Hash::make($request->new_password);
        }

        $admin->update($data);

        return back()->with('toast_success', 'Profile updated successfully!');
    }
}
