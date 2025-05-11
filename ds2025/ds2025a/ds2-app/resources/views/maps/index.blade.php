<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Carte des objectifs
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div id="map" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        var map = L.map('map').setView([0, 0], 2); // vue par défaut

        // Ajouter fond de carte
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        @if ($mapPins->isNotEmpty())
            var bounds = [];
            @foreach ($mapPins as $pin)
                @if (is_numeric($pin->latitude) && is_numeric($pin->longitude) && $pin->goal)
                    bounds.push([{{ $pin->latitude }}, {{ $pin->longitude }}]);
                    L.marker([{{ $pin->latitude }}, {{ $pin->longitude }}])
                        .addTo(map)
                        .bindPopup('<b>{{ addslashes($pin->location_name ?? "Épingle") }}</b><br>Objectif : {{ addslashes($pin->goal->title) }}');
                @endif
            @endforeach
            map.fitBounds(bounds);
        @else
            map.setView([36.8065, 10.1815], 5); // fallback: Tunis
        @endif
    </script>
</x-app-layout>
