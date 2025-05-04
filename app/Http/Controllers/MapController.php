<?php

namespace App\Http\Controllers;

use App\Models\MapPin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $mapPins = Auth::user()->mapPins()->with('goal')->get();
        $goals = Auth::user()->goals()->whereIn('visibility', ['public', 'friends'])->get();
        return view('maps.index', compact('mapPins', 'goals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'goal_id' => 'required|exists:goals,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'location_name' => 'nullable|string|max:255',
        ]);

        $goal = Auth::user()->goals()->findOrFail($request->goal_id);

        Auth::user()->mapPins()->create([
            'goal_id' => $goal->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'location_name' => $request->location_name,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Pin added successfully']);
    }
}