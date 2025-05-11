@extends('layouts.app')
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                 

                    <div class="mt-4">
                        <a href="{{ route('maps.index') }}"
                           class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Voir la carte des objectifs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="map" style="height: 500px;"></div>


@endsection