<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Carte des objectifs
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($mapPins->isEmpty())
                <p class="text-red-500">Aucune épingle trouvée.</p>
            @else
                <p class="text-green-500">{{ $mapPins->count() }} épingle(s) chargée(s).</p>
            @endif

            <!-- Carte -->
            <div id="map" style="height: 500px;" class="my-4 rounded shadow"></div>
        </div>
    </div>

    <!-- Leaflet CSS + JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Initialisation de la carte avec la vue centrée sur Tunis
        var map = L.map('map').setView([36.8065, 10.1815], 13); // Coordonnées de base (Tunis)

        // Ajouter un "tile layer" (carte de base)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @if ($mapPins->isNotEmpty())
            var bounds = [];
            @foreach ($mapPins as $pin)
                @if (is_numeric($pin->latitude) && is_numeric($pin->longitude) && isset($pin->goal->title))
                    // Ajouter un marqueur pour chaque épingle
                    var marker = L.marker([{{ $pin->latitude }}, {{ $pin->longitude }}]).addTo(map)
                        .bindPopup('<b>{{ addslashes($pin->location_name ?? 'Épingle') }}</b><br>Objectif : {{ addslashes($pin->goal->title) }}');
                    bounds.push([{{ $pin->latitude }}, {{ $pin->longitude }}]);
                @endif
            @endforeach
            // Ajuster la vue de la carte pour inclure toutes les épingles
            if (bounds.length > 0) {
                map.fitBounds(bounds);
            }
        @else
            // Si aucune épingle, définir la vue sur une position globale
            map.setView([0, 0], 2);
        @endif
    </script>
</x-app-layout>
