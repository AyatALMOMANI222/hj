<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;;

use App\Mail\CustomVerifyEmail;
use Illuminate\Auth\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'whatsapp',
        'address',
        'location',
        'is_admin',
        'role',
        'whatsapp',
        'language',
        'years_of_experience',
        'training_type',
        'car_type',
        'rating',
        'license_type',
        'age',
        'session_duration',
        'session_price',
        'session_time',
        'field_training_available',
        'test_preparation',
        'special_training_programs',
        'is_active',
        'profile_picture',
        'center_location',
        'center_name',
        'available_from',
        'available_to',
        'break_time_duration',
        'lesson_duration',
        'available_days'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $attributes = [
        'is_admin' => false,
    ];
    public function isCenter()
    {
        return $this->role === 'raining_center';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isTrainer()
    {
        return $this->role === 'instructor';
    }

    public function isTrainee()
    {
        return $this->role === 'trainee';
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    // العلاقة مع التقييمات التي تلقاها المستخدم كمدرب
    public function trainerRatings()
    {
        return $this->hasMany(Rating::class, 'trainer_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
    public function instructorCourses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    // العلاقة مع الدورات كمركز تدريبي
    public function centerCourses()
    {
        return $this->hasMany(Course::class, 'center_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
    public function drivingLessonsAsInstructor()
    {
        return $this->hasMany(DrivingLesson::class, 'instructor_id');
    }

    public function drivingLessonsAsCenter()
    {
        return $this->hasMany(DrivingLesson::class, 'center_id');
    }

    public function drivingLessonsCreatedBy()
    {
        return $this->hasMany(DrivingLesson::class, 'created_by');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'trainee_id');
    }


    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
}
