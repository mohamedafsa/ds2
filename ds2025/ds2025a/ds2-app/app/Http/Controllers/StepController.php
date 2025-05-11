<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStepRequest;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class StepController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ensure.user.owns.goal');
    }

    public function store(CreateStepRequest $request, Goal $goal)
    {
        $goal->steps()->create($request->validated());

        return redirect()->route('goals.show', $goal)->with('success', 'Step added successfully.');
    }
}