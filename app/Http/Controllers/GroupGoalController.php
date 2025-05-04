<?php

namespace App\Http\Controllers;

use App\Models\GroupGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupGoalController extends Controller
{
    public function index()
    {
        $groupGoals = GroupGoal::where('user_id', Auth::id())->with('goal')->get();
        return response()->json($groupGoals);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'goal_id' => 'required|exists:goals,id',
        ]);

        $groupGoal = GroupGoal::create([
            'goal_id' => $validated['goal_id'],
            'user_id' => Auth::id(),
            'joined_at' => now(),
        ]);

        return response()->json($groupGoal, 201);
    }

    public function show(GroupGoal $groupGoal)
    {
        $this->authorize('view', $groupGoal);
        return response()->json($groupGoal->load('goal'));
    }

    public function destroy(GroupGoal $groupGoal)
    {
        $this->authorize('delete', $groupGoal);
        $groupGoal->delete();
        return response()->json(null, 204);
    }
}
