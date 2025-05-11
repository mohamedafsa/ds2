<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Bootstrap 5.3 CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <!-- Inter Font -->
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
            <!-- AOS for animations -->
            <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
            <!-- Custom CSS -->
            <link href="{{ asset('css/app.css') }}" rel="stylesheet">

            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 sidebar">
                    <div class="card mb-4" data-aos="fade-up">
                        <div class="card-body">
                            <h5 class="card-title">Your Progress</h5>
                            @foreach ($objectives as $objective)
                                <div class="mb-3">
                                    <p>{{ $objective['title'] }}</p>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $objective['progress'] }}%;" aria-valuenow="{{ $objective['progress'] }}" aria-valuemin="0" aria-valuemax="100">{{ $objective['progress'] }}%</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-body">
                            <h5 class="card-title">Badges</h5>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($badges as $badge)
                                    <span class="badge badge-success">{{ $badge }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-md-9">
                    <div class="card hero-card mb-4" data-aos="fade-up">
                        <div class="card-body">
                            <h3 class="card-title">Welcome, {{ Auth::user()->name }}!</h3>
                            <p class="card-text">Ready to achieve your goals? Start by adding a new objective.</p>
                            <a href="#" class="btn btn-light">Add Objective</a>
                        </div>
                    </div>
                    <div class="card mb-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-body">
                            <h5 class="card-title">Recent Objectives</h5>
                            <ul class="list-group">
                                @foreach ($objectives as $objective)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $objective['title'] }}
                                        <div>
                                            <span class="badge bg-success me-2">{{ $objective['progress'] }}%</span>
                                            <small>Due: {{ $objective['deadline'] }}</small>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-body">
                            <h5 class="card-title">Quick Links</h5>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-outline-primary">View Map</a>
                                <a href="#" class="btn btn-outline-primary">Check Timeline</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</x-app-layout>
