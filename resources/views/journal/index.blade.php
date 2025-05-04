@extends('layouts.app')

@section('title', 'Journal')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="display-6 mb-4">Your Journal</h1>
        @if ($journals->isEmpty())
            <div class="alert alert-info">No journal entries yet.</div>
        @else
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach ($journals as $journal)
                    <div class="col">
                        <div class="card shadow h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $journal->title }}</h5>
                                <p class="card-text">{{ $journal->content }}</p>
                                <p class="text-muted small">Created: {{ $journal->created_at->format('Y-m-d') }}</p>
                                <p class="text-muted small">Goal: {{ $journal->goal->title }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection