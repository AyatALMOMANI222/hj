<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected  $table = 'vehicles';
    protected $fillable = [
        'user_id',
        'type',
        'model',
        'status',
        'location',
        'year',
        'registration_number',
        'color',
        'seats',
        'chassis_number',
        'fuel_type',
        'mileage',
        'engine_capacity',
        'last_service_date',
        'notes',
        'images'
    ];
    protected $casts = [
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function drivingLessons()
    {
        return $this->hasMany(DrivingLesson::class, 'vehicle_id');
    }
}
