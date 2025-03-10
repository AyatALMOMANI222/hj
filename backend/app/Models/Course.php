<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'cources';
    
    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
        'start_date',
        'end_date',
        'instructor_id',
        'center_id'
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
    ];

    public $timestamps = true;

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function center()
    {
        return $this->belongsTo(User::class, 'center_id');
    }
}
