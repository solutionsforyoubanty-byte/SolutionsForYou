<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Check if admin is super admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if admin is co-admin
     */
    public function isCoAdmin(): bool
    {
        return $this->role === 'co-admin';
    }

    /**
     * Get role badge HTML
     */
    public function getRoleBadgeAttribute(): string
    {
        return match($this->role) {
            'admin' => '<span class="badge badge-danger"><i class="fas fa-crown mr-1"></i>Admin</span>',
            'co-admin' => '<span class="badge badge-info"><i class="fas fa-user-shield mr-1"></i>Co-Admin</span>',
            default => '<span class="badge badge-secondary">Unknown</span>',
        };
    }

    /**
     * Get status badge HTML
     */
    public function getStatusBadgeAttribute(): string
    {
        return $this->is_active
            ? '<span class="badge badge-success">Active</span>'
            : '<span class="badge badge-secondary">Inactive</span>';
    }

    /**
     * Get avatar URL
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return asset('admin/admin-assets/img/undraw_profile.svg');
    }
}
