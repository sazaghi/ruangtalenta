<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-2xl font-bold">Halo, {{ $user->name }}!</h1>
        </div>
    </x-slot>
    <div class="container my-4">
        <div class="row g-4">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        Kelengkapan Profile
                    </div>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <!-- Bagian kiri -->
                        <div>
                            <h6 class="card-title mb-2">
                                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828911.png" alt="icon" width="20" class="me-2">
                                Tugas yang belum selesai :
                            </h6>
                            <ul class="mb-3">
                                <li>Tambahkan No. handphone</li>
                                <li>Tambahkan Alamat</li>
                                <li>Tambahkan Bio</li>
                            </ul>
                            <a href="#" class="btn btn-sm btn-primary">Lengkapi Sekarang</a>
                        </div>

                        <!-- Bagian kanan (circular progress) -->
                        <div class="text-center">
                            <svg width="100" height="100">
                                <circle cx="50" cy="50" r="45" stroke="#eee" stroke-width="10" fill="none"/>
                                <circle cx="50" cy="50" r="45" stroke="#ffc107" stroke-width="10" fill="none"
                                        stroke-dasharray="282.6"
                                        stroke-dashoffset="70" 
                                        stroke-linecap="round"
                                        transform="rotate(-90 50 50)" />
                                <text x="50%" y="50%" text-anchor="middle" dy=".3em" font-size="18">75%</text>
                            </svg>
                            <small class="text-muted d-block">Profile Complete</small>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        Recent Apply Job
                    </div>
                    <div class="card-body">
                        @forelse($recentJobs as $job)
                            <div class="mb-3">
                                <p class="text-gray-900 font-medium">{{ $job->postKerja->judul }}</p>
                                <p class="text-red-500 text-sm">{{ $job->postKerja->perusahaan->nama ?? 'Perusahaan' }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">Belum ada job yang kamu apply.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Featured
                    </div>
                    <div class="card-body">
                        @forelse($upcomingTests as $test)
                            <div class="mb-3 text-sm">
                                <p class="font-bold text-orange-600">📁 {{ $test->postKerja->perusahaan->nama ?? '-' }}</p>
                                <p>📝 {{ $test->tipe }}</p>
                                <p>💻 {{ $test->metode }}</p>
                                <p class="text-purple-600 text-xs mt-1">📅 {{ \Carbon\Carbon::parse($test->jadwal)->format('d F Y | H:i') }} WIB</p>
                            </div>
                            <hr class="my-2">
                        @empty
                            <p class="text-gray-500 text-sm">Belum ada jadwal interview atau test.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
