<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $goals = Auth::user()->goals()->latest()->take(5)->get();
        $badges = Auth::user()->badges()->with('goals')->latest()->take(3)->get();
        $timelines = Auth::user()->timelines()->with('goal')->latest()->take(5)->get();
        $journals = Auth::user()->journals()->with('goal')->latest()->take(5)->get();
        return view('dashboard.index', compact('goals', 'badges', 'timelines', 'journals'));
    }
}
