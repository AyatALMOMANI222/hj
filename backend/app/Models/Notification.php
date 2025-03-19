<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
protected $table ='notifications';
    protected $fillable = [
        'user_id',
        'register_id',
        'message',
        'type',
        'read_status',
        'read_at',
        'is_active',
    ];

    // العلاقة مع جدول المستخدمين (كل إشعار يخص مستخدم واحد)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

