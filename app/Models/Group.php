<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Group extends Model
{
   
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user')
                    ->withTimestamps();
    }
}

