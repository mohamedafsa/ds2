<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'title',
        'description',
        'category',
        'visibility',
        'deadline',
        'progress_percentage',
        'file_path',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public function mapPins()
    {
        return $this->hasMany(MapPin::class);
    }

    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_user_goal')
                    ->withTimestamps()
                    ->withPivot('awarded_at');
    }

    public function isVisibleTo($user)
    {
        if ($this->visibility === 'public') {
            return true;
        }
        if ($this->visibility === 'private') {
            return $this->user_id === $user->id;
        }
        if ($this->visibility === 'friends') {
            return $this->user_id === $user->id || $user->friends()->where('friend_id', $this->user_id)->exists();
        }
        return false;
    }
}