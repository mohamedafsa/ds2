@extends('layouts.app')

@section('title', 'Maps')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="display-6 mb-4">Goal Map</h1>
        @if ($mapPins->isEmpty())
            <div class="alert alert-info">No map pins yet. Add a goal with a location!</div>
        @else
            <div id="map" class="shadow mb-4"></div>
            <ul class="list-group">
                @foreach ($mapPins as $pin)
                    <li class="list-group-item">
                        <strong>{{ $pin->location_name ?? 'Pin' }}</strong> ({{ $pin->latitude }}, {{ $pin->longitude }})
                        <span class="text-muted small">Goal: {{ $pin->goal->title }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@section('scripts')
<script>
    // Initialize Leaflet map
    var map = L.map('map').setView([0, 0], 2); // Center on world map
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add markers for map pins
    @foreach ($mapPins as $pin)
        L.marker([{{ $pin->latitude }}, {{ $pin->longitude }}])
            .addTo(map)
            .bindPopup('<b>{{ $pin->location_name ?? "Goal Pin" }}</b><br>Goal: {{ $pin->goal->title }}');
    @endforeach

    // Allow placing new pins (example)
    map.on('click', function(e) {
        var popup = L.popup()
            .setLatLng(e.latlng)
            .setContent('New Pin: ' + e.latlng.lat.toFixed(4) + ', ' + e.latlng.lng.toFixed(4) + '<br><a href="#" onclick="savePin(' + e.latlng.lat + ',' + e.latlng.lng + ')">Save Pin</a>')
            .openOn(map);
    });

    function savePin(lat, lng) {
        // Implement AJAX to save pin (requires MapController@store)
        alert('Save pin at ' + lat + ', ' + lng + ' (implement save functionality)');
    }
</script>
@endsection