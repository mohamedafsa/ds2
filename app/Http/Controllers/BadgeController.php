<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'criteria'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'badge_user_goal')
                    ->withTimestamps()
                    ->withPivot('goal_id', 'awarded_at');
    }

    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'badge_user_goal')
                    ->withTimestamps()
                    ->withPivot('user_id', 'awarded_at');
    }
}