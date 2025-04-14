<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

    <div class="max-w-6xl mx-auto py-12">
        <h2 class="text-3xl font-bold text-left mb-6">Daftar Pekerjaan</h2>

        <!-- Tombol Tambah Job -->
        <div class="d-flex justify-content-end mb-4">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#submitJobModal">
                + Tambah Job
            </button>
        </div>
        <!-- Modal Submit Job -->
        <div class="modal fade" id="submitJobModal" tabindex="-1" aria-labelledby="submitJobModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <form action="{{ url('/job') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                    <h5 class="modal-title" id="submitJobModalLabel">Submit Job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Pekerjaan</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Pekerjaan</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label">Gaji (Opsional)</label>
                        <input type="number" class="form-control" id="salary" name="salary">
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" name="location" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="experience" class="form-label">Experience</label>
                        <input type="text" name="experience" class="form-control">
                    </div>
                    <div class="mb-3">
                    <label for="job_type" class="form-label">Tipe Pekerjaan</label>
                        <select name="job_type" class="form-control">
                            <option value="">Pilih Tipe</option>
                            <option value="Full-Time">Full-Time</option>
                            <option value="Part-Time">Part-Time</option>
                            <option value="Remote">Remote</option>
                            <option value="Internship">Internship</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline Lamaran</label>
                        <input type="date" name="deadline" class="form-control">
                    </div>
                    
                    <label class="form-label">Metode Seleksi:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="CV Screening" id="cv" name="selection_methods[]">
                        <label class="form-check-label" for="cv">CV Screening</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Interview" id="interview" name="selection_methods[]">
                        <label class="form-check-label" for="interview">Interview</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="Test" id="test" name="selection_methods[]">
                        <label class="form-check-label" for="test">Test</label>
                    </div>
                    </div>

                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Posting Pekerjaan</button>
                    </div>
                </form>
                </div>
            </div>
            </div>


        <!-- Daftar Job -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6"  x-data="{ showModal: false, selectedLamaran: null }">
            @foreach($jobs as $job)
            <!-- Card Job -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $job->title }}</h5>
                    <p class="card-text">{{ $job->description }}</p>
                    <p class="card-text fw-bold">Rp {{ number_format($job->salary, 0, ',', '.') }}</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#jobModal{{ $job->id }}">
                            Lihat Detail
                        </button>

                        <a href="{{ route('job.edit', $job->id) }}" class="btn btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('job.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Detail Job -->
            <div class="modal fade" id="jobModal{{ $job->id }}" tabindex="-1" aria-labelledby="jobModalLabel{{ $job->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="jobModalLabel{{ $job->id }}">{{ $job->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Deskripsi:</strong><br> {{ $job->description }}</p>
                            <p><strong>Gaji:</strong> Rp {{ number_format($job->salary, 0, ',', '.') }}</p>
                            <p><strong>Lokasi:</strong> {{ $job->location ?? '-' }}</p>
                            <p><strong>Pengalaman:</strong> {{ $job->experience ?? '-' }} tahun</p>
                            <p><strong>Tipe Pekerjaan:</strong> {{ $job->job_type ?? '-' }}</p>
                            <p><strong>Deadline Lamaran:</strong> {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->translatedFormat('d M Y') : '-' }}</p>

                            @if($job->selection_methods)
                                <p><strong>Metode Seleksi:</strong> {{ implode(', ', $job->selection_methods) }}</p>
                            @endif

                            <p class="text-muted"><strong>Diposting pada:</strong> {{ $job->created_at->format('d M Y') }}</p>

                            <h6>Pelamar:</h6> 
                            @forelse($job->lamarans as $lamaran)
                                <div class="mb-3">
                                    <p>👤 {{ $lamaran->user->name }}</p>
                                    <p>📧 {{ $lamaran->user->email }}</p>
                                    @if($lamaran->tanggal_interview)
                                        <p>📅 Interview: {{ \Carbon\Carbon::parse($lamaran->tanggal_interview)->format('d M Y H:i') }}</p>
                                        <p>🔗 <a href="{{ $lamaran->link_meet }}" target="_blank">Link Google Meet</a></p>
                                    @else
                                        <!-- Tombol Panggil -->
                                        <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#interviewModal{{ $lamaran->id }}">
                                            Panggil Interview
                                        </button>
                                    @endif
                                </div>

                                <!-- Modal Interview -->
                                <div class="modal fade" id="interviewModal{{ $lamaran->id }}" tabindex="-1" aria-labelledby="interviewLabel{{ $lamaran->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('interview.schedule') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="lamaran_id" value="{{ $lamaran->id }}">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="interviewLabel{{ $lamaran->id }}">Jadwalkan Interview</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="tanggal" class="form-label">Tanggal & Waktu Interview</label>
                                                        <input type="datetime-local" name="tanggal_interview" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="link_meet" class="form-label">Link Google Meet</label>
                                                        <input type="url" name="link_meet" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Kirim Undangan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">Belum ada pelamar.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    <!-- JavaScript untuk Modal -->
    <script>
        const openModalBtn = document.getElementById("openModal");
        const closeModalBtn = document.getElementById("closeModalBtn");
        const jobModal = document.getElementById("jobModal");

        openModalBtn?.addEventListener("click", () => jobModal.classList.remove("hidden"));
        closeModalBtn?.addEventListener("click", () => jobModal.classList.add("hidden"));

        // Close modal if user clicks outside modal content
        window.addEventListener("click", function(e) {
            if (e.target === jobModal) {
                jobModal.classList.add("hidden");
            }
        });
    </script>


    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>
