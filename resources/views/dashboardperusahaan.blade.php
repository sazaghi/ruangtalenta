<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-2xl font-bold">Halo, {{ $user->name }}!</h1>
        </div>
    </x-slot>
        <div class="container my-4">
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Job Post Activity
                        </div>
                        <div class="p-4">
                            <select id="jobSelect" class="form-select">
                                <option value="">Pilih Job</option>
                                @foreach ($jobList as $job)
                                    <option value="{{ $job->id }}">{{ $job->title }}</option>
                                @endforeach
                            </select>
                            <canvas id="applicantChart" class="mt-6" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Job Terbaru
                        </div>
                        <div class="card-body">
                        @forelse($recentJobs as $job)
                            <div class="mb-3 text-sm">
                                <p class="font-bold text-blue-600">📌 {{ $job->title }}</p>
                                <p class="text-gray-500 text-xs">🕒 {{ $job->created_at->diffForHumans() }}</p>
                                <p class="text-gray-600">📍 {{ $job->location ?? '-' }}</p>
                            </div>
                            <hr class="my-2">
                        @empty
                            <p class="text-gray-500 text-sm">Belum ada postingan pekerjaan dari kamu.</p>
                        @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('applicantChart').getContext('2d');
            let jobChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Jumlah Pendaftar',
                        borderColor: '#FFA500',
                        backgroundColor: '#FFA500',
                        data: [],
                        tension: 0.4,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Event on change dropdown
            document.getElementById('jobSelect').addEventListener('change', function () {
                let jobId = this.value;
                if (jobId) {
                    fetch(`/chart-data/${jobId}`)
                        .then(res => res.json())
                        .then(data => {
                            jobChart.data.labels = data.dates;
                            jobChart.data.datasets[0].data = data.totals;
                            jobChart.update();
                        });
                } else {
                    jobChart.data.labels = [];
                    jobChart.data.datasets[0].data = [];
                    jobChart.update();
                }
            });
        </script>
</x-app-layout>
