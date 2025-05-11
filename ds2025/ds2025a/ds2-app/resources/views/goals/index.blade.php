@extends('layouts.app')

@section('title', 'Goals')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="display-6 mb-4">Your Goals</h1>
        <a href="{{ route('goals.create') }}" class="btn btn-primary mb-4">Create New Goal</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($goals->isEmpty())
            <div class="alert alert-info">No goals yet. Start by creating one!</div>
        @else
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach ($goals as $goal)
                    <div class="col">
                        <div class="card shadow h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('goals.show', $goal) }}" class="text-primary">{{ $goal->title }}</a>
                                </h5>
                                <p class="card-text">{{ $goal->description }}</p>
                                <p class="text-muted small">Category: {{ $goal->category }}</p>
                                <p class="text-muted small">Progress: {{ $goal->progress_percentage }}%</p>
                                <p class="text-muted small">Deadline: {{ $goal->deadline ? $goal->deadline->format('Y-m-d') : 'None' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection