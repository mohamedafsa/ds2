<?php

namespace App\Traits;

use App\Models\Badge;
use Illuminate\Support\Facades\Auth;

trait AwardBadges
{
    protected function checkAndAwardBadges($goal)
    {
        if ($goal->progress_percentage >= 100) {
            $badge = Badge::where('criteria', 'complete_goal')->first();
            if ($badge && !$goal->badges()->where('badge_id', $badge->id)->exists()) {
                Auth::user()->badges()->attach($badge->id, [
                    'goal_id' => $goal->id,
                    'awarded_at' => now(),
                ]);
            }
        }

        $completedGoals = Auth::user()->goals()->where('progress_percentage', 100)->count();
        if ($completedGoals >= 3) {
            $badge = Badge::where('criteria', 'complete_3_goals')->first();
            if ($badge && !Auth::user()->badges()->where('badge_id', $badge->id)->exists()) {
                Auth::user()->badges()->attach($badge->id, [
                    'goal_id' => $goal->id,
                    'awarded_at' => now(),
                ]);
            }
        }
    }
}