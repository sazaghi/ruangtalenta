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
                    <div class="mb-4">
                        <label for="deadline" class="form-label">Skill required</label>
                        <input type="text" name="skills" id="skills" class="mt-1 block w-full" value="{{ old('skills') }}" placeholder="Contoh: PHP, Laravel, JavaScript">
                        @error('skills') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <label class="form-label">Metode Seleksi:</label>
                    @foreach ($selectionMethods as $method)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $method->name }}" id="sm{{ $loop->index }}" name="selection_methods[]">
                            <label class="form-check-label" for="sm{{ $loop->index }}">{{ $method->name }}</label>
                        </div>
                    @endforeach
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Posting Pekerjaan</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6"  x-data="{ showModal: false, selectedLamaran: null }">
            @foreach($jobs as $job)
            <!-- Card Job -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $job->title }}</h5>
                    <p class="card-text">{{ $job->description }}</p>
                    <p class="card-text fw-bold">Rp {{ number_format($job->salary, 0, ',', '.') }}</p>
                    <div class="d-flex gap-2 flex-wrap">
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
