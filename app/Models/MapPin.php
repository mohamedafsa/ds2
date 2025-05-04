<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapPin extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'latitude',
        'longitude',
        'location_name',
        'user_id', 
    ];

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

}