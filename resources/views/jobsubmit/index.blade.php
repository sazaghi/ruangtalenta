<x-app-layout>
<style>
        .table-container {
            background-color: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        .table-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
            margin-right: 10px;
        }
        .action-icons i {
            cursor: pointer;
            margin-right: 8px;
            color: #6c757d;
        }
        .action-icons i:hover {
            color: #0d6efd;
        }
        .nav-tabs .nav-link.active {
            border-bottom: 2px solid #6f42c1;
            font-weight: bold;
        }
        .skill-badge {
        padding: 5px 10px;
        border-radius: 20px;
        background-color: #0d6efd;
        color: #fff;
        display: inline-block;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    .remove-skill {
        margin-left: 6px;
        font-weight: bold;
        color: #fff;
    }
    </style>
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
        <x-slot name="header">
            <h2 class="text-left mb-6" style="font-family: 'Roboto', sans-serif; font-size: 30px;">
                {{ __('Post Jobs') }}
            </h2>
        </x-slot>
        
        <!-- Modal Submit Job -->
        <!-- Modal Submit Job -->
<div class="modal fade" id="submitJobModal" tabindex="-1" aria-labelledby="submitJobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('job.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="submitJobModalLabel">Posting Lowongan Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Judul Pekerjaan</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label">Lokasi</label>
                            <input type="text" name="location" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gaji Minimum (Opsional)</label>
                            <input type="number" class="form-control" name="salary_min" placeholder="Contoh: 5000000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gaji Maksimum (Opsional)</label>
                            <input type="number" class="form-control" name="salary_max" placeholder="Contoh: 10000000">
                        </div>

                        <div class="col-md-6">
                            <label for="experience" class="form-label">Pengalaman</label>
                            <input type="text" name="experience" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="job_type" class="form-label">Tipe Pekerjaan</label>
                            <select name="job_type" class="form-select">
                                <option value="">Pilih Tipe</option>
                                <option value="Full-Time">Full-Time</option>
                                <option value="Part-Time">Part-Time</option>
                                <option value="Remote">Remote</option>
                                <option value="Internship">Internship</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="description" class="form-label">Deskripsi Pekerjaan</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="deadline" class="form-label">Deadline Lamaran</label>
                            <input type="date" name="deadline" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select class="form-select" name="category_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="skills" class="form-label">Skill yang Dibutuhkan</label>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-search me-2"></i>
                                <input type="text" id="skill-input" class="form-control" placeholder="Contoh: PHP, Laravel..." autocomplete="off">
                            </div>

                            <div id="skill-tags" class="skill-tags mb-2">
                                @php
                                    $existingSkills = old('skills', []);
                                    if (is_string($existingSkills)) {
                                        $existingSkills = json_decode($existingSkills, true);
                                    }
                                @endphp
                                @foreach ($existingSkills as $skill)
                                    <span class="badge bg-primary me-1 mb-1 skill-badge">
                                        {{ $skill }} <i class="remove-skill ms-1" style="cursor:pointer;" data-skill="{{ $skill }}">&times;</i>
                                    </span>
                                @endforeach
                            </div>

                            <input type="hidden" name="skills" id="skills-hidden" value='@json($existingSkills)'>
                            @error('skills') <span class="text-danger text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Tahapan Seleksi</label>
                            <div id="selection-stages-container">
                                <div class="input-group mb-2">
                                    <input type="text" name="selection_stages[0][name]" class="form-control" placeholder="Contoh: CV Screening">
                                    <button class="btn btn-danger remove-stage" type="button">×</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-selection-stage">+ Tambah Tahapan</button>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Metode Seleksi:</label>
                            <div class="row">
                                @foreach ($selectionMethods as $method)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $method->name }}" id="sm{{ $loop->index }}" name="selection_methods[]">
                                            <label class="form-check-label" for="sm{{ $loop->index }}">{{ $method->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
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

    
    @php
        $activeTab = request('tab', 'active'); // Ambil dari query string, default 'active'
    @endphp
    <div class="d-flex justify-content-between align-items-center mb-3">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ $activeTab === 'active' ? 'active' : '' }}"
                href="?tab=active">
                Active <span class="badge bg-secondary">{{ $activeCount }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab === 'inactive' ? 'active' : '' }}"
                href="?tab=inactive">
                Inactive <span class="badge bg-secondary">{{ $inactiveCount }}</span></a>
            </li>
        </ul>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#submitJobModal">+ Post a Job</button>
    </div>


<div class="table-container">
    @php
        $filteredJobs = match($activeTab) {
            'active' => $jobs->where('status', 'active'),
            'inactive' => $jobs->where('status', 'inactive'),
            'expired' => $jobs->filter(fn($job) => \Carbon\Carbon::parse($job->deadline)->isPast()),
            default => $jobs,
        };
    @endphp

    @if ($filteredJobs->isEmpty())
        <p class="text-muted">Tidak ada job untuk tab ini.</p>
    @else
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Lokasi</th>
                    <th>Deadline</th>
                    <th>Gaji</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($filteredJobs as $index => $job)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $job->title }}</td>
                        <td>{{ $job->location }}</td>
                        <td>{{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</td>
                        <td>Rp{{ number_format($job->salary_min) }} - Rp{{ number_format($job->salary_max) }}</td>

                        <td>
                                <span class="badge bg-{{ $job->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                        </td>
                        <td>
                            <a href="{{ route('job.edit', $job->id) }}" class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('job.destroy', $job->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus pekerjaan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-secondary me-1">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
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

        let stageIndex = 1;

        document.getElementById('add-selection-stage').addEventListener('click', function () {
            const container = document.getElementById('selection-stages-container');
            const inputGroup = document.createElement('div');
            inputGroup.classList.add('input-group', 'mb-2');

            inputGroup.innerHTML = `
                <input type="text" name="selection_stages[${stageIndex}][name]" class="form-control" placeholder="Contoh: Interview">
                <button class="btn btn-danger remove-stage" type="button">×</button>
            `;

            container.appendChild(inputGroup);
            stageIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-stage')) {
                e.target.closest('.input-group').remove();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
        const skillInput = document.getElementById('skill-input');
        const skillTags = document.getElementById('skill-tags');
        const hiddenSkills = document.getElementById('skills-hidden');

        let skills = JSON.parse(hiddenSkills.value || '[]');

        function renderSkills() {
            skillTags.innerHTML = '';
            skills.forEach(skill => {
                const badge = document.createElement('span');
                badge.className = 'badge bg-primary me-1 mb-1 skill-badge';
                badge.innerHTML = `${skill} <i class="remove-skill ms-1" style="cursor:pointer;" data-skill="${skill}">&times;</i>`;
                skillTags.appendChild(badge);
            });
            hiddenSkills.value = JSON.stringify(skills);
        }

        skillInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const value = skillInput.value.trim();
                if (value && !skills.includes(value)) {
                    skills.push(value);
                    renderSkills();
                }
                skillInput.value = '';
            }
        });

        skillTags.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-skill')) {
                const skillToRemove = e.target.getAttribute('data-skill');
                skills = skills.filter(s => s !== skillToRemove);
                renderSkills();
            }
        });

        renderSkills();
    });
    </script>


    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>
