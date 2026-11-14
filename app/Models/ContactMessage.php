<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'subject',
        'message',
        'status',
        'ip_address',
    ];

    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }
}

