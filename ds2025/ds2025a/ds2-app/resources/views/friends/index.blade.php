@extends('layouts.app')

@section('title', 'Friends')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="display-6 mb-4">Friends</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <h4>Your Friends</h4>
        @if ($friends->isEmpty())
            <div class="alert alert-info">No friends yet.</div>
        @else
            <ul class="list-group mb-4">
                @foreach ($friends as $friend)
                    <li class="list-group-item">{{ $friend->name }}</li>
                @endforeach
            </ul>
        @endif
        <h4>Pending Friend Requests</h4>
        @if ($pendingRequests->isEmpty())
            <div class="alert alert-info">No pending requests.</div>
        @else
            <ul class="list-group mb-4">
                @foreach ($pendingRequests as $request)
                    <li class="list-group-item">
                        {{ $request->user->name }}
                        <form action="{{ route('friends.accept', $request) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Accept</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
        <h4>Add a Friend</h4>
        <form method="POST" action="{{ route('friends.request') }}">
            @csrf
            <div class="mb-3">
                <label for="friend_id" class="form-label">Select User</label>
                <select class="form-select @error('friend_id') is-invalid @enderror" id="friend_id" name="friend_id" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('friend_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Send Friend Request</button>
        </form>
    </div>
</div>
@endsection