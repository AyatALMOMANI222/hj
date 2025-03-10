<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    protected $fillable = [
        'driving_lessons_id',
        'trainee_id',
        'status',
        'payment_status',
        'rating',
        'feedback',
        'notes',
        'trainer_notes',
        'is_reminded',
    ];
    protected $dates = ['created_at', 'updated_at'];

    // العلاقات مع النماذج الأخرى
    public function drivingLesson()
    {
        return $this->belongsTo(DrivingLesson::class, 'driving_lessons_id');
    }

    public function trainee()
    {
        return $this->belongsTo(User::class, 'trainee_id');
    }
}
