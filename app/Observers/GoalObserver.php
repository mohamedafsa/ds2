<?php

namespace App\Observers;

use App\Models\Goal;
use App\Services\BadgeService;

class GoalObserver
{
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    public function updated(Goal $goal)
    {
        $this->badgeService->checkAndAwardBadges($goal);
    }
}