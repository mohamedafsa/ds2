<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGoalRequest;
use App\Http\Requests\UpdateGoalRequest;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenAI\Client;

class GoalController extends Controller
{
    public function index()
    {
        $goals = Auth::user()->goals()->with(['steps', 'mapPin'])->get();
        return response()->json($goals);
    }

    public function store(CreateGoalRequest $request)
    {
        $goal = Auth::user()->goals()->create($request->validated());
        return response()->json($goal, 201);
    }

    public function show(Goal $goal)
    {
        $this->authorize('view', $goal);
        return response()->json($goal->load(['steps', 'mapPin', 'journals']));
    }

    public function update(UpdateGoalRequest $request, Goal $goal)
    {
        $this->authorize('update', $goal);
        $goal->update($request->validated());
        return response()->json($goal);
    }

    public function destroy(Goal $goal)
    {
        $this->authorize('delete', $goal);
        $goal->delete();
        return response()->json(null, 204);
    }

    public function suggestSteps(Request $request, Goal $goal, Client $openAI)
    {
        $this->authorize('update', $goal);
        $prompt = "Suggest 5 intermediate steps for achieving the goal: {$goal->title}. Provide concise steps.";
        $response = $openAI->completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => 100,
        ]);

        $steps = explode("\n", trim($response->choices[0]->text));
        return response()->json(['suggested_steps' => array_filter($steps)]);
    }
}