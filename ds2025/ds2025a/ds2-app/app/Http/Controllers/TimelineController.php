<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $timelines = Auth::user()->timelines()->with('goal')->get();
        $goals = Auth::user()->goals()->whereIn('visibility', ['public', 'friends'])->get();
        return view('timeline.index', compact('timelines', 'goals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'goal_id' => 'required|exists:goals,id',
            'event_type' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_description' => 'nullable|string',
        ]);

        $goal = Auth::user()->goals()->findOrFail($request->goal_id);

        Auth::user()->timelines()->create([
            'goal_id' => $goal->id,
            'event_type' => $request->event_type,
            'event_date' => $request->event_date,
            'event_description' => $request->event_description,
        ]);

        return redirect()->route('timeline.index')->with('success', 'Timeline event added successfully.');
    }
}