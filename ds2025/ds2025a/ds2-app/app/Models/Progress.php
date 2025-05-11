<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'step_id',
        'user_id',
        'completion_date',
        'notes',
    ];

    protected $casts = [
        'completion_date' => 'date',
    ];

    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}