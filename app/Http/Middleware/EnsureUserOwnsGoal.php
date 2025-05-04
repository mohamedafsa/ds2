<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Goal;

class EnsureUserOwnsGoal
{
    public function handle(Request $request, Closure $next)
    {
        $goal = Goal::find($request->route('goal'));

        if (! $goal || $goal->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized access to this goal.');
        }

        return $next($request);
    }
}
