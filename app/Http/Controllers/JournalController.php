<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $journals = Auth::user()->journals()->with('goal')->get();
        $goals = Auth::user()->goals()->whereIn('visibility', ['public', 'friends'])->get();
        return view('journal.index', compact('journals', 'goals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'goal_id' => 'required|exists:goals,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $goal = Auth::user()->goals()->findOrFail($request->goal_id);

        Auth::user()->journals()->create([
            'goal_id' => $goal->id,
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('journal.index')->with('success', 'Journal entry added successfully.');
    }
}