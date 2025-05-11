<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Add this

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory; // Add HasFactory

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function goals()
    {
        return $this->hasMany(Goal::class);
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

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user')
                    ->withTimestamps();
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_user_goal')
                    ->withTimestamps()
                    ->withPivot('goal_id', 'awarded_at');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->withPivot('status')
                    ->withTimestamps()
                    ->wherePivot('status', 'accepted');
    }

    public function pendingFriendRequests()
    {
        return $this->hasMany(Friend::class, 'friend_id')
                    ->where('status', 'pending');
    }
}