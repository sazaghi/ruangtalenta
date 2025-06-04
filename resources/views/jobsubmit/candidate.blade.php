{{-- resources/views/job/candidates.blade.php --}}
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
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

    <x-slot name="header">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-2xl font-bold">Candidate List</h2>
        </div>
    </x-slot>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" action="{{ route('job.candidate') }}" style="max-width: 300px;">
            <select name="job_id" class="form-select" onchange="this.form.submit()">
                <option value="">Select Job</option>
                @foreach ($jobs as $job)
                    <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                        {{ $job->title }}
                    </option>
                @endforeach
            </select>
        </form>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" form="shortlist-form" class="btn btn-primary">+ Add to Short List</button>
            <a href="?tab=shortlist&job_id={{ request('job_id') }}" class="btn btn-outline-primary">View Short List</a>

            <div class="ms-3">
                <label>Sort by:</label>
                {{-- Wrap the select in a form and add a hidden input for job_id --}}
                <form method="GET" action="{{ route('job.candidate') }}" class="d-inline">
                    <input type="hidden" name="job_id" value="{{ request('job_id') }}">
                    <input type="hidden" name="tab" value="{{ request('tab') }}"> {{-- Keep the current tab --}}
                    <select name="sort_by" class="form-select d-inline w-auto" onchange="this.form.submit()">
                        <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="highest_score" {{ request('sort_by') == 'highest_score' ? 'selected' : '' }}>Highest Score</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    @if ($selectedJob)
        @php
            $activeTab = request('tab', 'pending');
            $lamarans = $selectedJob->lamarans;
        @endphp

        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ $activeTab === 'pending' ? 'active' : '' }}"
                   href="?tab=pending&job_id={{ $selectedJob->id }}">Pending <span class="badge bg-secondary">{{ $pendingCount }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab === 'accepted' ? 'active' : '' }}"
                   href="?tab=accepted&job_id={{ $selectedJob->id }}">Accepted <span class="badge bg-secondary">{{ $acceptedCount }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab === 'rejected' ? 'active' : '' }}"
                   href="?tab=rejected&job_id={{ $selectedJob->id }}">Rejected <span class="badge bg-secondary">{{ $rejectedCount }}</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab === 'shortlist' ? 'active' : '' }}"
                   href="?tab=shortlist&job_id={{ $selectedJob->id }}">Shortlist <span class="badge bg-secondary">{{ $shortlistCount }}</span></a>
            </li>
        </ul>

        <div class="table-container">
            @php
                $filtered = match($activeTab) {
                    'pending' => $lamarans->where('status', 'pending'),
                    'accepted' => $lamarans->where('status', 'Accepted'),
                    'rejected' => $lamarans->where('status', 'Rejected'),
                    'shortlist' => $lamarans->filter(function($lamaran) {
                        return !in_array(strtolower($lamaran->status), ['pending', 'accepted', 'rejected']);
                    }),
                    default => $lamarans,
                };
            @endphp
                
            @if ($filtered->isEmpty())
                <p class="text-muted">There are no candidates for this tab.</p>
            @else
                @if($activeTab == 'pending')
                    <form id="shortlist-form" method="POST" action="{{ route('shortlist.run') }}">
                    @csrf
                        <input type="hidden" name="post_kerjas_id" value="{{ $selectedJob?->id }}">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Apply Time</th>
                                    <th>Score</th>
                                    <th>Action</th>
                                    @if($activeTab == 'pending')
                                        <th>Select</th>
                                    @endif
                                    @if($activeTab == 'shortlist')
                                        <th>Finalize</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($filtered as $lamaran)
                                    @php
                                        $user = $lamaran->user;
                                    @endphp
                                    <tr>
                                        <td><div class="table-avatar"></div></td>
                                        <td>{{ $user->name }}</td>
                                        <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                        <td>{{ $lamaran->created_at->format('d M Y') }}</td>
                                        <td><strong>{{ $lamaran->score }}</strong></td>
                                        <td>
                                            <i class="bi bi-eye" title="View"
                                            onclick="showApplicantProfile(
                                                `{{ $user->profile->full_name ?? '-' }}`,
                                                `{{ $user->email }}`,
                                                `{{ $lamaran->score ?? 0 }}`,
                                                `{{ $user->profile?->skills ? implode(', ', json_decode($user->profile->skills, true)) : '-' }}`,
                                                `{{ $user->profile->complete_address ?? '-' }}`,
                                                `{{ $user->profile->contact_number ?? '-' }}`,
                                                `{{ $user->profile->bio ?? '-' }}`,
                                                `{{ $user->profile->avatar ?? '-' }}`,
                                                `{{ $lamaran->resume_path ?? '-' }}`,
                                                `{{ $lamaran->application_letter_path ?? '-' }}`,
                                                `{{ $lamaran->portfolio_link ?? '-' }}`,
                                                `{{ $user->profile->education ?? '-' }}`, // education
                                                `{{ $user->workExperiences ?? '-' }}` // experience
                                            )">
                                            </i>

                                        </td>
                                        <td><input type="checkbox" name="lamaran_ids[]" value="{{ $lamaran->id }}"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                @else
                    <input type="hidden" name="post_kerjas_id" value="{{ $selectedJob?->id }}">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Apply Time</th>
                                <th>Score</th>
                                <th>Action</th>
                                @if($activeTab == 'pending')
                                    <th>Select</th>
                                @endif
                                @if($activeTab == 'shortlist')
                                    <th>Finalize</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($filtered as $lamaran)
                                @php
                                    $user = $lamaran->user;
                                @endphp
                                <tr>
                                    <td><div class="table-avatar"></div></td>
                                    <td>{{ $user->name }}</td>
                                    <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                                    <td>{{ $lamaran->created_at->format('d M Y') }}</td>
                                    <td><strong>{{ $lamaran->score }}</strong></td>
                                    <td class="action-icons">
                                       <i class="bi bi-eye" title="View"
                                            onclick="showApplicantProfile(
                                                `{{ $user->profile->full_name ?? '-' }}`,
                                                `{{ $user->email }}`,
                                                `{{ $lamaran->score ?? 0 }}`,
                                                `{{ $user->profile?->skills ? implode(', ', json_decode($user->profile->skills, true)) : '-' }}`,
                                                `{{ $user->profile->complete_address ?? '-' }}`,
                                                `{{ $user->profile->contact_number ?? '-' }}`,
                                                `{{ $user->profile->bio ?? '-' }}`,
                                                `{{ $user->profile->avatar ?? '-' }}`,
                                                `{{ $lamaran->resume_path ?? '-' }}`,
                                                `{{ $lamaran->application_letter_path ?? '-' }}`,
                                                `{{ $lamaran->portfolio_link ?? '-' }}`,
                                                `{{ $user->profile->education ?? '-' }}`, // education
                                                `{{ $user->workExperiences ?? '-' }}` // experience
                                            )">
                                            </i>

                                            @if ($canInterview or $canTest)
                                            <i class="bi bi-calendar-event" title="Invite for Interview"
                                                onclick="openInterviewModal({{ $user->id }})"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('lamaran.finalize', $lamaran->id) }}" method="POST" class="mt-2">
                                                @csrf
                                                <button type="submit" name="status" value="Rejected" class="btn btn-sm btn-danger">Reject</button>
                                                <button type="submit" name="status" value="Accepted" class="btn btn-sm btn-success">Accept</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                @endif    
            @endif
        </div>
    @else
    <p class="text-muted">Select the vacancy first</p>
    @endif
    @if ($selectedJob)
    {{-- Modal Interview --}}
        @foreach($lamarans as $lamaran)
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
                            <h5 class="modal-title">Invitation for {{ $user->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                        @if ($interviews->has($user->id))
                            <h6>Previous Interviews:</h6>
                            @foreach ($interviews->get($user->id) as $iv)
                                <div class="border rounded p-2 mb-2 bg-light">
                                    <p><strong>Interview Schedule:</strong> {{ \Carbon\Carbon::parse($iv->jadwal)->translatedFormat('l, d M Y H:i') }}</p>
                                    <p><strong>Interview Link:</strong> 
                                        @if ($iv->link)
                                            <a href="{{ $iv->link }}" target="_blank">{{ $iv->link }}</a>
                                        @else
                                            -
                                        @endif
                                    </p>
                                    <p><strong>Method:</strong> {{ $iv->metode }}</p>
                                    <p><strong>Result:</strong> {{ $iv->result_note }}</p>
                                </div>
                            @endforeach
                            <hr>
                        @else
                            <p>No previous invitations.</p>
                        @endif
                            <div class="mb-3">
                                <label class="form-label">Selection Stage</label>
                                <select name="selection_template_id" class="form-control" required>
                                    <option value="" disabled selected>Select selection type</option>
                                    @foreach ($selectiontemplate as $option)
                                        <option value="{{ $option->id }}">{{ $option->stage_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="judul" class="form-control" placeholder="Example: Interview Stage 1">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-control" required>
                                    <option value="" disabled selected>Select selection type</option>
                                    <option value="Online">Online</option>
                                    <option value="Offline">Offline</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Interview Schedule</label>
                                <input type="datetime-local" name="jadwal" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Interview Link</label>
                                <input type="url" name="link" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Additional Message</label>
                                <textarea name="message" class="form-control" rows="3" placeholder="Optional"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Send Invitation</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
    {{-- Applicant Profile Modal --}}
    <div class="modal fade" id="viewApplicantModal" tabindex="-1" aria-labelledby="viewApplicantModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Full Applicant Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center mb-4">
                                <div class="table-avatar me-3">
                                    <img id="modalUserAvatar"
                                        src="{{ asset('default-avatar.png') }}"
                                        alt="Avatar"
                                        class="rounded-circle"
                                        width="40" height="40">
                                </div>

                            <div>
                                <h5 id="modalUserName" class="mb-0">Applicant Name</h5>
                                <small id="modalUserEmail" class="text-muted">Email</small>
                            </div>
                        </div>

                        <div>
                            <p><strong>Match Score:</strong> <span id="modalUserScore">0</span></p>
                            <p><strong>Tags / Skills:</strong> <span id="modalUserTags">-</span></p>
                            <p><strong>Address:</strong> <span id="modalUserAddress">-</span></p>
                            <p><strong>Phone Number:</strong> <span id="modalUserPhone">-</span></p>
                            <p><strong>Self Description:</strong></p>
                            <p id="modalUserDescription">-</p>
                            <p><strong>Resume:</strong> <span id="modalUserResume">-</span></p>
                            <p><strong>Application Letter:</strong> <span id="modalUserApplicationLetter">-</span></p>
                            <p><strong>Portfolio:</strong> <span id="modalUserPortfolio">-</span></p>
                            <p><strong>Education:</strong></p>
                            <ul id="modalUserEducation">
                                <li>-</li>
                            </ul>

                            <p><strong>Work Experience:</strong></p>
                            <ul id="modalUserExperienceList">
                                <li>-</li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
      </div>
    <script>
        function showApplicantProfile(
            name, email, score, tags, address, phone, description, avatar,
            resume, applicationLetter, portfolio,
            education, experience
        ) {
            document.getElementById('modalUserName').innerText = name;
            document.getElementById('modalUserEmail').innerText = email;
            document.getElementById('modalUserScore').innerText = score;
            document.getElementById('modalUserTags').innerText = tags;
            document.getElementById('modalUserAddress').innerText = address;
            document.getElementById('modalUserPhone').innerText = phone;
            document.getElementById('modalUserDescription').innerText = description;

            document.getElementById('modalUserAvatar').src = avatar !== '-' ? `/storage/${avatar}` : '{{ asset('default-avatar.png') }}';

            document.getElementById('modalUserResume').innerHTML = resume !== '-' ? `<a href="/storage/${resume}" target="_blank">View CV</a>` : '-';
            document.getElementById('modalUserApplicationLetter').innerHTML = applicationLetter !== '-' ? `<a href="/storage/${applicationLetter}" target="_blank">View Application Letter</a>` : '-';
            document.getElementById('modalUserPortfolio').innerHTML = portfolio !== '-' ? `<a href="${portfolio}" target="_blank">View Portfolio</a>` : '-';

            // Set education (as JSON)
            const eduElement = document.getElementById('modalUserEducation');
            eduElement.innerHTML = '-'; // Default
            try {
                const eduData = JSON.parse(education);
                if (Array.isArray(eduData) && eduData.length > 0) {
                    eduElement.innerHTML = '';
                    eduData.forEach(item => {
                        eduElement.innerHTML += `<li><strong>${item.year}</strong> - ${item.major} at ${item.university}<br><em>${item.description}</em></li>`;
                    });
                }
            } catch (e) {
                eduElement.innerHTML = '<li>Not available</li>';
            }

            // Set experience
            const expElement = document.getElementById('modalUserExperienceList');
            expElement.innerHTML = '-';
            try {
                const expData = JSON.parse(experience);
                if (Array.isArray(expData) && expData.length > 0) {
                    expElement.innerHTML = '';
                    expData.forEach(item => {
                        expElement.innerHTML += `
                            <li>
                                <strong>${item.position}</strong> at ${item.company} <br>
                                <small>${item.start_date} s/d ${item.end_date}</small><br>
                                <em>${item.description ?? '-'}</em>
                            </li>`;
                    });
                }
            } catch (e) {
                expElement.innerHTML = '<li>Not available</li>';
            }

            new bootstrap.Modal(document.getElementById('viewApplicantModal')).show();
        }


        function openInterviewModal(userId) {
            const modalId = 'interviewModal-' + userId;
            const modalElement = document.getElementById(modalId);

            if (modalElement) {
                // If modal found, open modal
                new bootstrap.Modal(modalElement).show();
            } else {
                // If modal not found, show error message (debugging)
                console.error('Modal for user with ID ' + userId + ' not found.');
            }
        }
    </script>
</x-app-layout>