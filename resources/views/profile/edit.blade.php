<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <style>
        .skill-badge {
            display: inline-flex;
            align-items: center;
            background-color: #e0f2fe; /* light blue */
            color: #0369a1; /* blue-700 */
            padding: 6px 12px;
            font-size: 0.875rem;
            border-radius: 9999px;
            margin-right: 6px;
            margin-bottom: 6px;
            transition: background-color 0.2s ease;
        }

        .skill-badge i {
            margin-left: 8px;
            cursor: pointer;
            font-style: normal; /* remove italic */
            font-weight: bold;
            color: #0c4a6e; /* darker blue */
        }

        .skill-badge i:hover {
            color: #dc2626; /* red for delete hover */
        }
    </style>

    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark">{{ __('My Profile') }}</h2>
    </x-slot>

    <div class="container my-4">
        <div class="row g-4">
        @if(auth()->user()->hasRole('pencarikerja'))
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Update Your Profile</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bio.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex mb-4 align-items-center">
                                <div class="me-4">
                                    @if($bio && $bio->avatar)
                                        <img src="{{$bio->avatar}}" alt="Avatar" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover;">
                                    @else
                                        <div style="width: 100px; height: 100px; background: #ccc; border-radius: 8px;"></div>
                                    @endif
                                </div>
                                <div>
                                    <input type="file" name="avatar" accept="image/*" class="form-control">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="full_name" class="form-control" placeholder="Enter your full name" autocomplete="off" value="{{ old('full_name', $bio->full_name ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" name="contact_number" class="form-control" placeholder="Enter your contact number" autocomplete="off" value="{{ old('contact_number', $bio->contact_number ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Personal Website</label>
                                    <input type="url" name="website" class="form-control" placeholder="Enter your website URL" autocomplete="off" value="{{ old('website', $bio->website ?? '') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Bio</label>
                                <textarea name="bio" class="form-control" rows="3" placeholder="Write a short bio..." autocomplete="off">{{ old('bio', $bio->bio ?? '') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-3">
                <!-- Social Network -->
                <form method="POST" action="{{ route('bio.store') }}">
                    @csrf
                    <div class="card mb-3">
                        <div class="card-header">Social Network</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label><i class="bi bi-facebook"></i> Facebook</label>
                                <input type="text" name="facebook" class="form-control" 
                                    value="{{ old('facebook', $bio->facebook ?? '') }}" 
                                    placeholder="https://facebook.com/yourhandle" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label><i class="bi bi-twitter"></i> Twitter</label>
                                <input type="text" name="twitter" class="form-control" 
                                    value="{{ old('twitter', $bio->twitter ?? '') }}" 
                                    placeholder="https://twitter.com/yourhandle" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label><i class="bi bi-instagram"></i> Instagram</label>
                                <input type="text" name="instagram" class="form-control" 
                                    value="{{ old('instagram', $bio->instagram ?? '') }}" 
                                    placeholder="https://instagram.com/yourhandle" autocomplete="off">
                            </div>
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>

                <form method="POST" action="{{ route('bio.store') }}">
                    @csrf
                    <div class="card mb-3">
                        <div class="card-header">My Skills</div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-search me-2"></i>
                                <input type="text" id="skill-input" class="form-control" placeholder="e.g. Angular, Laravel..." autocomplete="off">
                            </div>

                            <div id="skill-tags" class="skill-tags mb-3">
                                @php
                                    $existingSkills = old('skills', $bio->skills ?? []);

                                    // Kalau string kosong atau "null", ubah ke array kosong
                                    if (is_string($existingSkills)) {
                                        $decoded = json_decode($existingSkills, true);
                                        $existingSkills = is_array($decoded) ? $decoded : [];
                                    }
                                @endphp

                                @foreach ($existingSkills as $skill)
                                    <span class="skill-badge">
                                        {{ $skill }} <i class="remove-skill" data-skill="{{ $skill }}">&times;</i>
                                    </span>
                                @endforeach
                            </div>

                            <input type="hidden" name="skills" id="skills-hidden" value='@json($existingSkills)'>

                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-save me-1"></i> Save Skills
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Info -->
        <form method="POST" action="{{ route('bio.store') }}">
            @csrf
            <div class="card mt-4">
                <div class="card-header">Contact Information</div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <input 
                                type="text" 
                                name="country" 
                                class="form-control" 
                                placeholder="Enter your country" 
                                autocomplete="off"
                                value="{{ old('country', $bio->country ?? '') }}"
                            >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input 
                                type="text" 
                                name="city" 
                                class="form-control" 
                                placeholder="Enter your city" 
                                autocomplete="off"
                                value="{{ old('city', $bio->city ?? '') }}"
                            >
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Complete Address</label>
                        <input 
                            type="text" 
                            name="complete_address" 
                            class="form-control" 
                            placeholder="Enter your complete address" 
                            autocomplete="off"
                            value="{{ old('complete_address', $bio->complete_address ?? '') }}"
                        >
                    </div>
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-save me-1"></i> Save Address
                    </button>
                </div>
            </div>
        </form>


        <!-- Education Section -->
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Education</span>
                <button type="button" class="btn btn-sm btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#educationModal">
                    + Add Education
                </button>
            </div>
            <div class="card-body" id="education-section">
                @foreach ($user->educations as $education)
                    <div class="p-3 mb-3">
                        <div class="d-flex align-items-start">
                            <span class="badge bg-secondary me-3">{{ $education->year }}</span>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-1">{{ $education->major }}</h6>
                                    <form method="POST" action="{{ route('educations.destroy', $education) }}" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="text-primary mb-1">{{ $education->university }}</div>
                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">{{ $education->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Education Modal -->
        <div class="modal fade" id="educationModal" tabindex="-1" aria-labelledby="educationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('educations.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="educationModalLabel">Add Education</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Major</label>
                        <input type="text" class="form-control" name="major" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">University</label>
                        <input type="text" class="form-control" name="university" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Year</label>
                        <input type="text" class="form-control" name="year" placeholder="e.g. 2012-2014">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Education</button>
                    </div>
                </div>
                </form>
            </div>
        </div>


        <!-- Work and Experience -->
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Work & Experience</span>
                <button type="button" class="btn btn-sm btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#addWorkExperienceModal">
                    + Add Experience
                </button>
            </div>
            <div class="card-body" id="work-section">
                @foreach ($user->workExperiences as $experience)
                    <div class="p-3 mb-3">
                        <div class="d-flex align-items-start">
                            <span class="badge bg-secondary me-3">
                                {{ \Carbon\Carbon::parse($experience->start_date)->format('Y') }} -
                                {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('Y') : 'Present' }}
                            </span>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-1">{{ $experience->position }}</h6>
                                    <form method="POST" action="{{ route('work-experiences.destroy', $experience) }}" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="text-primary mb-1">{{ $experience->company }}</div>
                                <p class="mb-0 text-muted" style="font-size: 0.9rem;">{{ $experience->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Add Work Experience Modal -->
        <div class="modal fade" id="addWorkExperienceModal" tabindex="-1" aria-labelledby="addWorkExperienceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('work-experiences.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="addWorkExperienceModalLabel">Add Work Experience</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control" name="position" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="company" class="form-label">Company</label>
                        <input type="text" class="form-control" name="company" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date">
                    </div>
                    </div>
                    
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Experience</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        @elseif(auth()->user()->hasRole('perusahaan'))
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Update Your Profile</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('bio.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex mb-4 align-items-center">
                                <div class="me-4">
                                    @if($bio && $bio->avatar)
                                        <img src="{{ $bio->avatar }}" alt="Avatar" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover;">
                                    @else
                                        <div style="width: 100px; height: 100px; background: #ccc; border-radius: 8px;"></div>
                                    @endif
                                </div>
                                <div>
                                    <input type="file" name="avatar" accept="image/*" class="form-control">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" name="full_name" class="form-control" placeholder="Enter your full name" autocomplete="off" value="{{ old('full_name', $bio->full_name ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Company Email</label>
                                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" name="contact_number" class="form-control" placeholder="Enter your contact number" autocomplete="off" value="{{ old('contact_number', $bio->contact_number ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Personal Website</label>
                                    <input type="url" name="website" class="form-control" placeholder="Enter your website URL" autocomplete="off" value="{{ old('website', $bio->website ?? '') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="bio" class="form-control" rows="3" placeholder="Write a short bio..." autocomplete="off">{{ old('bio', $bio->bio ?? '') }}</textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <!-- Social Network -->
                <form method="POST" action="{{ route('bio.store') }}">
                    @csrf
                    <div class="card mb-3">
                        <div class="card-header">Social Network</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label><i class="bi bi-facebook"></i> Facebook</label>
                                <input type="text" name="facebook" class="form-control" 
                                    value="{{ old('facebook', $bio->facebook ?? '') }}" 
                                    placeholder="https://facebook.com/yourhandle" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label><i class="bi bi-twitter"></i> Twitter</label>
                                <input type="text" name="twitter" class="form-control" 
                                    value="{{ old('twitter', $bio->twitter ?? '') }}" 
                                    placeholder="https://twitter.com/yourhandle" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label><i class="bi bi-instagram"></i> Instagram</label>
                                <input type="text" name="instagram" class="form-control" 
                                    value="{{ old('instagram', $bio->instagram ?? '') }}" 
                                    placeholder="https://instagram.com/yourhandle" autocomplete="off">
                            </div>
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Contact Info -->
            <form method="POST" action="{{ route('bio.store') }}">
                @csrf
                <div class="card mt-3">
                    <div class="card-header">Contact Information</div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                <input 
                                    type="text" 
                                    name="country" 
                                    class="form-control" 
                                    placeholder="Enter your country" 
                                    autocomplete="off"
                                    value="{{ old('country', $bio->country ?? '') }}"
                                >
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City</label>
                                <input 
                                    type="text" 
                                    name="city" 
                                    class="form-control" 
                                    placeholder="Enter your city" 
                                    autocomplete="off"
                                    value="{{ old('city', $bio->city ?? '') }}"
                                >
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Complete Address</label>
                            <input 
                                type="text" 
                                name="complete_address" 
                                class="form-control" 
                                placeholder="Enter your complete address" 
                                autocomplete="off"
                                value="{{ old('complete_address', $bio->complete_address ?? '') }}"
                            >
                        </div>
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-save me-1"></i> Save Address
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('skill-input');
        const tagsContainer = document.getElementById('skill-tags');
        const hiddenInput = document.getElementById('skills-hidden');

        let skills = JSON.parse(hiddenInput.value || '[]');

        function renderTags() {
            tagsContainer.innerHTML = '';
            skills.forEach(skill => {
                const tag = document.createElement('span');
                tag.className = 'skill-badge';
                tag.innerHTML = `${skill} <i class="remove-skill" data-skill="${skill}">&times;</i>`;
                tagsContainer.appendChild(tag);
            });
            hiddenInput.value = JSON.stringify(skills);
        }

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                let value = input.value.trim().toUpperCase();

                if (value && !skills.includes(value)) {
                    skills.push(value);
                    input.value = '';
                    renderTags();
                }
            }
        });

        tagsContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-skill')) {
                const skill = e.target.dataset.skill;
                skills = skills.filter(s => s !== skill);
                renderTags();
            }
        });

        renderTags(); // initial render
    });
</script>



</x-app-layout>
