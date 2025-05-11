@extends('layouts.app')

@section('title', 'Timeline')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="display-6 mb-4">Your Timeline</h1>
        @if ($timelines->isEmpty())
            <div class="alert alert-info">No timeline events yet.</div>
        @else
            <div id="calendar" class="shadow"></div>
        @endif
    </div>
</div>
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [
                @foreach ($timelines as $timeline)
                    {
                        title: '{{ $timeline->event_type }} ({{ $timeline->goal->title }})',
                        start: '{{ $timeline->event_date->format('Y-m-d') }}',
                        description: '{{ $timeline->event_description }}'
                    },
                @endforeach
            ],
            eventClick: function(info) {
                alert('Event: ' + info.event.title + '\nDescription: ' + info.event.extendedProps.description);
            }
        });
        calendar.render();
    });
</script>
@endsection