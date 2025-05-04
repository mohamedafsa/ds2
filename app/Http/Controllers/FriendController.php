<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $friends = Auth::user()->friends;
        $pendingRequests = Auth::user()->pendingFriendRequests;
        $users = User::where('id', '!=', Auth::id())->get();
        return view('friends.index', compact('friends', 'pendingRequests', 'users'));
    }

    public function request(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);

        $friendId = $request->friend_id;
        if ($friendId == Auth::id()) {
            return redirect()->route('friends.index')->with('error', 'You cannot add yourself as a friend.');
        }

        $existing = Friend::where('user_id', Auth::id())->where('friend_id', $friendId)->first();
        if ($existing) {
            return redirect()->route('friends.index')->with('error', 'Friend request already sent.');
        }

        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $friendId,
            'status' => 'pending',
        ]);

        return redirect()->route('friends.index')->with('success', 'Friend request sent.');
    }

    public function accept(Friend $friend)
    {
        if ($friend->friend_id !== Auth::id()) {
            abort(403);
        }

        $friend->update(['status' => 'accepted']);
        Friend::create([
            'user_id' => Auth::id(),
            'friend_id' => $friend->user_id,
            'status' => 'accepted',
        ]);

        return redirect()->route('friends.index')->with('success', 'Friend request accepted.');
    }
}