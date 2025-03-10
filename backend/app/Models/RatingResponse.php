<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating_id',
        'responder_id',
        'response',
        'type'
    ];


    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }


    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id');
    }
}
