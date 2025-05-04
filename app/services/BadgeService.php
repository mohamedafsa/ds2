<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class BadgeService
{
    public function checkAndAwardBadges(Goal $goal)
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