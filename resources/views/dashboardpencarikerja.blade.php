<x-app-layout>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
            });
        </script>
    @endif

    @php
        $radius = 45;
        $circumference = 2 * pi() * $radius;
        $offset = $circumference - ($circumference * $profileCompletion / 100);
    @endphp

    <x-slot name="header">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-2xl font-bold">Hello, {{ $user->name }}!</h1>
        </div>
    </x-slot>

    <div class="container my-4">
        <div class="row g-4">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        Profile Completion
                    </div>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <!-- Left Section -->
                        <div>
                            <h6 class="card-title mb-2">
                                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828911.png" alt="icon" width="20" class="me-2">
                                Incomplete Tasks:
                            </h6>
                            <ul class="mb-3">
                                @if (!$bio)
                                    <li>Profile not yet created. Please complete your profile.</li>
                                @else
                                    @forelse($incompleteFields as $field)
                                        <li>Add {{ $field }}</li>
                                    @empty
                                        <li>All profile fields are complete!</li>
                                    @endforelse
                                @endif
                            </ul>
                            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary">Complete Now</a>
                        </div>

                        <!-- Right Section (circular progress) -->
                        <div class="text-center">
                            <svg width="100" height="100">
                                <!-- Background circle -->
                                <circle cx="50" cy="50" r="{{ $radius }}" stroke="#eee" stroke-width="10" fill="none"/>

                                <!-- Foreground progress circle -->
                                <circle cx="50" cy="50" r="{{ $radius }}" stroke="#ffc107" stroke-width="10" fill="none"
                                        stroke-dasharray="{{ $circumference }}"
                                        stroke-dashoffset="{{ $offset }}"
                                        stroke-linecap="round"
                                        transform="rotate(-90 50 50)" />

                                <!-- Text percentage -->
                                <text x="50%" y="50%" text-anchor="middle" dy=".3em" font-size="18">
                                    {{ $profileCompletion }}%
                                </text>
                            </svg>
                            <small class="text-muted d-block">Profile Complete</small>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        Recently Applied Jobs
                    </div>
                    <div class="card-body">
                        @forelse($recentJobs as $job)
                            <div class="mb-3">
                                <p class="mb-0 text-gray-900 fw-semibold">{{ $job->postKerja->title }}</p>
                                <p class="mb-0 text-muted small"><i class="bi bi-building me-1"></i>{{ $job->postKerja->perusahaan->nama ?? 'Company' }}</p>
                            </div>  
                        @empty
                            <p class="text-gray-500 text-sm">You haven't applied to any jobs yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Upcoming Selection
                    </div>
                    <div class="card-body">
                        @forelse($upcomingTests as $test)
                            <div class="mb-3 text-sm d-flex gap-2">
                                <div>
                                    <p class="fw-semibold text-orange-600 mb-1">
                                        <i class="bi bi-building me-1"></i>{{ $test->postKerja->user->company->profile->full_name ?? '-' }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="bi bi-pencil-square me-1 text-secondary"></i>{{ $test->tipe }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="bi bi-laptop me-1 text-secondary"></i>{{ $test->metode }}
                                    </p>
                                    <p class="text-purple-600 text-xs mt-1">
                                        <i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($test->jadwal)->format('d F Y | H:i') }} WIB
                                    </p>
                                </div>
                            </div>
                            <hr class="my-2">
                        @empty
                            <p class="text-gray-500 text-sm">No upcoming interviews or tests scheduled.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
