@extends('layouts.app')

@section('title', $goal->title)

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">{{ $goal->title }}</h3>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $goal->description }}</p>
                <p class="text-muted small">Category: {{ $goal->category }}</p>
                <p class="text-muted small">Visibility: {{ $goal->visibility }}</p>
                <p class="text-muted small">Progress: {{ $goal->progress_percentage }}%</p>
                <p class="text-muted small">Deadline: {{ $goal->deadline ? $goal->deadline->format('Y-m-d') : 'None' }}</p>
                <div class="mt-3">
                    <a href="{{ route('goals.index') }}" class="btn btn-secondary">Back to Goals</a>
                    <form action="{{ route('goals.destroy', $goal) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this goal?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Goal</button>
                    </form>
                </div>
                <h4 class="mt-4">Steps</h4>
                @if ($goal->steps->isEmpty())
                    <div class="alert alert-info">No steps yet.</div>
                @else
                    <ul class="list-group">
                        @foreach ($goal->steps as $step)
                            <li class="list-group-item {{ $step->is_completed ? 'text-muted' : '' }}">
                                <span class="{{ $step->is_completed ? 'text-decoration-line-through' : '' }}">{{ $step->title }}</span>
                                @if ($step->due_date)
                                    <span class="text-muted small"> (Due: {{ $step->due_date->format('Y-m-d') }})</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection