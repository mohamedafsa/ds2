<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGoalRequest;
use App\Http\Requests\UpdateGoalRequest;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WebGoalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ensure.user.owns.goal')->only(['show', 'destroy', 'updateProgress']);
    }

    public function index()
    {
        $goals = Auth::user()->goals;
        $badges = Auth::user()->badges()->with('goals')->get();
        return view('goals.index', compact('goals', 'badges'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(CreateGoalRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('goals', 'public');
            $data['file_path'] = $path;
        }

        Auth::user()->goals()->create($data);
        return redirect()->route('goals.index')->with('success', 'Goal created successfully.');
    }

    public function show(Goal $goal)
    {
        return view('goals.show', compact('goal'));
    }

    public function destroy(Goal $goal)
    {
        if ($goal->file_path) {
            Storage::disk('public')->delete($goal->file_path);
        }
        $goal->delete();
        return redirect()->route('goals.index')->with('success', 'Goal deleted successfully.');
    }

    public function updateProgress(UpdateGoalRequest $request, Goal $goal)
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($goal->file_path) {
                Storage::disk('public')->delete($goal->file_path);
            }
            $path = $request->file('file')->store('goals', 'public');
            $data['file_path'] = $path;
        }

        $goal->update($data);
        return redirect()->route('goals.show', $goal)->with('success', 'Progress updated successfully.');
    }
}