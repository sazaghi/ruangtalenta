@php
    $selectedJob = null;
    if(request('job_id')) {
        $selectedJob = $jobs->firstWhere('id', request('job_id'));
    }
    $methods = is_array($selectedJob->selection_methods ?? null) ? $selectedJob->selection_methods : [];
    $canInterview = in_array('Interview', $methods);
    $canTest = in_array('Test', $methods);
@endphp

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
      .subtext {
      font-size: 0.75rem;
      color: #6c757d;
      }
      .action-icons i {
      cursor: pointer;
      margin-right: 8px;
      color: #6c757d;
      }
      .action-icons i:hover {
      color: #0d6efd;
      }
      .search-bar {
      border-radius: 20px;
      padding-left: 30px;
      background-image: url('https://cdn-icons-png.flaticon.com/512/49/49116.png');
      background-size: 16px;
      background-position: 10px center;
      background-repeat: no-repeat;
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

    <x-slot name="header">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-2xl font-bold">Daftar Kandidat</h2>
        </div>
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div style="max-width: 300px;">
            <input type="text" class="form-control search-bar" placeholder="Search">
        </div>
        <form method="GET" action="{{ route('job.candidate') }}" style="max-width: 300px;">
            <select name="job_id" class="form-select" onchange="this.form.submit()">
                <option value="">Pilih Job</option>
                @foreach ($jobs as $job)
                    <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                        {{ $job->title }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="table-container">
        @if ($selectedJob)
            @if ($selectedJob->lamarans->isEmpty())
                <p class="text-muted">Belum ada pelamar untuk lowongan <strong>{{ $selectedJob->title }}</strong>.</p>
            @else
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tag</th>
                            <th>Score</th>
                            <th>Aksi</th>
                            <th>Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($selectedJob->lamarans as $lamaran)
                            @php
                                $user = $lamaran->user;
                                $interview = $interviews[$user->id] ?? null;
                            @endphp
                            <tr>
                                <td><div class="table-avatar"></div></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                    </div>
                                </td>
                                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                <td>
                                    <span class="badge bg-dark text-white">#PHP</span>
                                    <span class="badge bg-dark text-white">#Laravel</span>
                                </td>
                                <td><strong>{{ $lamaran->score }}</strong></td>
                                <td class="action-icons">
                                    <i class="bi bi-eye" title="Lihat"
                                       onclick="showApplicantProfile(`{{ $user->name }}`, `{{ $user->email }}`, `{{ $lamaran->skor ?? 0 }}`, '-', '-', '-', '-')"></i>

                                    @if ($canInterview or $canTest)
                                    <i class="bi bi-calendar-event" title="Undang Interview"
                                        onclick="openInterviewModal({{ $user->id }})"></i>

                                    @endif

                                    <i class="bi bi-x-circle" title="Tolak Lamaran"
                                       onclick="openRejectModal({{ $user->id }})"></i>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Hasil Interview
                                        </button>
                                        <ul class="dropdown-menu p-3" style="min-width: 300px; max-height: 300px; overflow-y: auto;">
                                        @if ($interviews->has($user->id))
                                            <h6>Interview Sebelumnya:</h6>
                                            @foreach ($interviews->get($user->id) as $iv)
                                                <div class="border rounded p-2 mb-2 bg-light">
                                                    <p><strong>Jadwal Interview:</strong> {{ \Carbon\Carbon::parse($iv->jadwal)->translatedFormat('l, d M Y H:i') }}</p>
                                                    <p><strong>Link Interview:</strong> 
                                                        @if ($iv->link)
                                                            <a href="{{ $iv->link }}" target="_blank">{{ $iv->link }}</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </p>
                                                    <p><strong>Metode:</strong> {{ $iv->metode }}</p>
                                                    <p><strong>Result:</strong> {{ $iv->result_note }}</p>
                                                    <form action="{{ route('interview.update.note', $iv->id) }}" method="POST" class="mt-1">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="d-flex justify-content-between">
                                                            <button type="submit" class="btn btn-sm btn-fail">Tolak</button>
                                                            <button type="submit" name="status" value="Lolos Seleksi {{$iv->tipe}}" class="btn btn-sm btn-primary">Diterima</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endforeach
                                            <hr>
                                        @else
                                            <p>Belum ada interview sebelumnya.</p>
                                        @endif
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @else
            <p class="text-muted">Silakan pilih lowongan terlebih dahulu.</p>
        @endif
    </div>

    @if ($selectedJob)
    {{-- Modal Interview --}}
        @foreach($selectedJob->lamarans as $lamaran)
            @php
                $user = $lamaran->user;
                $interview = $interviews[$user->id] ?? null;
            @endphp
            <div class="modal fade" id="interviewModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('interview.store') }}" method="POST" class="modal-content">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="job_id" value="{{ $selectedJob->id }}">

                        <div class="modal-header">
                            <h5 class="modal-title">Undangan Interview untuk {{ $user->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                        @if ($interviews->has($user->id))
                            <h6>Interview Sebelumnya:</h6>
                            @foreach ($interviews->get($user->id) as $iv)
                                <div class="border rounded p-2 mb-2 bg-light">
                                    <p><strong>Jadwal Interview:</strong> {{ \Carbon\Carbon::parse($iv->jadwal)->translatedFormat('l, d M Y H:i') }}</p>
                                    <p><strong>Link Interview:</strong> 
                                        @if ($iv->link)
                                            <a href="{{ $iv->link }}" target="_blank">{{ $iv->link }}</a>
                                        @else
                                            -
                                        @endif
                                    </p>
                                    <p><strong>Metode:</strong> {{ $iv->metode }}</p>
                                    <p><strong>Result:</strong> {{ $iv->result_note }}</p>
                                </div>
                            @endforeach
                            <hr>
                        @else
                            <p>Belum ada interview sebelumnya.</p>
                        @endif
                            <div class="mb-3">
                                <label class="form-label">Judul</label>
                                <input type="text" name="judul" class="form-control" placeholder="Contoh: Interview Tahap 1">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tipe</label>
                                <select name="type" class="form-control" required>
                                    <option value="" disabled selected>Pilih tipe seleksi</option>
                                    <option value="Online">Online</option>
                                    <option value="Offline">Offline</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jadwal Interview</label>
                                <input type="datetime-local" name="jadwal" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Link Interview</label>
                                <input type="url" name="link" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pesan Tambahan</label>
                                <textarea name="message" class="form-control" rows="3" placeholder="Opsional"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" type="submit">Kirim Undangan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
    {{-- Modal Tolak --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <form action="{{ route('application.reject') }}" method="POST" class="modal-content">
                  @csrf
                  @method('POST')
                  <input type="hidden" name="user_id" id="rejectUserId">
                  @if ($selectedJob)
                      <input type="hidden" name="job_id" value="{{ $selectedJob->id }}">
                  @endif
                  <div class="modal-header">
                      <h5 class="modal-title">Tolak Lamaran</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                  </div>
                  <div class="modal-body">
                      <p>Apakah kamu yakin ingin menolak lamaran ini?</p>
                      <div class="mb-3">
                          <label class="form-label">Pesan Penolakan (Opsional)</label>
                          <textarea name="message" class="form-control" rows="3" placeholder="Opsional"></textarea>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button class="btn btn-danger" type="submit">Tolak Lamaran</button>
                  </div>
              </form>
          </div>
      </div>

    {{-- Modal Profil Pelamar --}}
    <div class="modal fade" id="viewApplicantModal" tabindex="-1" aria-labelledby="viewApplicantModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Profil Lengkap Pelamar</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                  </div>
                  <div class="modal-body">
                      <div class="d-flex align-items-center mb-4">
                          <div class="table-avatar me-3"></div>
                          <div>
                              <h5 id="modalUserName" class="mb-0">Nama Pelamar</h5>
                              <small id="modalUserEmail" class="text-muted">Email</small>
                          </div>
                      </div>

                      <div>
                          <p><strong>Skor Kecocokan:</strong> <span id="modalUserScore">0</span></p>
                          <p><strong>Tag / Skill:</strong> <span id="modalUserTags">-</span></p>
                          <p><strong>Alamat:</strong> <span id="modalUserAddress">-</span></p>
                          <p><strong>No. Telepon:</strong> <span id="modalUserPhone">-</span></p>
                          <p><strong>Deskripsi Diri:</strong></p>
                          <p id="modalUserDescription">-</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>

    <script>
        function showApplicantProfile(name, email, score, tags, address, phone, description) {
            document.getElementById('modalUserName').innerText = name;
            document.getElementById('modalUserEmail').innerText = email;
            document.getElementById('modalUserScore').innerText = score;
            document.getElementById('modalUserTags').innerText = tags;
            document.getElementById('modalUserAddress').innerText = address;
            document.getElementById('modalUserPhone').innerText = phone;
            document.getElementById('modalUserDescription').innerText = description;

            new bootstrap.Modal(document.getElementById('viewApplicantModal')).show();
        }

        function openInterviewModal(userId) {
            const modalId = 'interviewModal-' + userId;
            const modalElement = document.getElementById(modalId);

            if (modalElement) {
                // Jika modal ditemukan, buka modal
                new bootstrap.Modal(modalElement).show();
            } else {
                // Jika modal tidak ditemukan, tunjukkan pesan kesalahan (debugging)
                console.error('Modal untuk user dengan ID ' + userId + ' tidak ditemukan.');
            }
        }



        function openTestModal(userId) {
            document.getElementById('testUserId').value = userId;
            new bootstrap.Modal(document.getElementById('testModal')).show();
        }

        function openRejectModal(userId) {
            document.getElementById('rejectUserId').value = userId;
            new bootstrap.Modal(document.getElementById('rejectModal')).show();
        }
    </script>
</x-app-layout>
