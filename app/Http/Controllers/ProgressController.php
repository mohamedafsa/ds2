<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        $progress = Progress::where('user_id', Auth::id())->get();
        return response()->json($progress);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'step_id' => 'required|exists:steps,id',
            'completion_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $progress = Progress::create([
            'step_id' => $validated['step_id'],
            'user_id' => Auth::id(),
            'completion_date' => $validated['completion_date'],
            'notes' => $validated['notes'],
        ]);

        return response()->json($progress, 201);
    }

    public function show(Progress $progress)
    {
        $this->authorize('view', $progress);
        return response()->json($progress);
    }

    public function update(Request $request, Progress $progress)
    {
        $this->authorize('update', $progress);
        $validated = $request->validate([
            'completion_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);
        $progress->update($validated);
        return response()->json($progress);
    }

    public function destroy(Progress $progress)
    {
        $this->authorize('delete', $progress);
        $progress->delete();
        return response()->json(null, 204);
    }
}
