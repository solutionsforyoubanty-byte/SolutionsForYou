<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'service_id',
        'message',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'new' => '<span class="badge badge-primary">New</span>',
            'read' => '<span class="badge badge-warning">Read</span>',
            'replied' => '<span class="badge badge-success">Replied</span>',
            default => '<span class="badge badge-secondary">Unknown</span>',
        };
    }
}
