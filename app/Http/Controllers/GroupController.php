<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $groups = Auth::user()->groups()->with('goals')->get();
        return view('groups.index', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $group->users()->attach(Auth::id());

        return redirect()->route('groups.index')->with('success', 'Group created successfully.');
    }

    public function join(Group $group)
    {
        $group->users()->attach(Auth::id());
        return redirect()->route('groups.index')->with('success', 'Joined group successfully.');
    }

    public function addGoal(Request $request, Group $group)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:studies,sport,reading,projects,health,other',
            'visibility' => 'required|in:private,friends,public',
            'deadline' => 'nullable|date',
        ]);

        if (!$group->users()->where('user_id', Auth::id())->exists()) {
            abort(403, 'You must be a member of the group to add goals.');
        }

        $group->goals()->create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'visibility' => $request->visibility,
            'deadline' => $request->deadline,
            'progress_percentage' => 0,
        ]);

        return redirect()->route('groups.index')->with('success', 'Goal added to group successfully.');
    }
}