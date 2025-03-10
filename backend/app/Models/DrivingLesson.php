<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrivingLesson extends Model
{
    use HasFactory;
    protected $table = 'driving_lessons';
    protected $fillable = [
        'course_id',
        'instructor_id',
        'center_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'status',
        'max_students',
        'visibility',
        'created_by',
        'price',
        'vehicle_id',
        'duration',
        'training_type'
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function center()
    {
        return $this->belongsTo(User::class, 'center_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'driving_lessons_id');
    }
}
