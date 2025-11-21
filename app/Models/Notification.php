<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'title', 
        'message',
        'user_role',
        'user_id',
        'data',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public static function createNotification($type, $title, $message, $userRole = null, $userId = null, $data = null)
    {
        return self::create([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'user_role' => $userRole,
            'user_id' => $userId,
            'data' => $data
        ]);
    }
}