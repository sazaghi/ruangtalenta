<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Find Jobs</title>
  <link rel="icon" type="image/png" href="{{ asset('images/page_logo.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #f8f9fa;
    }
    .hero-section {
      background: linear-gradient(90deg, #fcb045, #fd1d1d);
      color: white;
      padding: 40px 20px;
      text-align: center;
    }
    .filter-section {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 8px rgba(0,0,0,0.1);
    }
    .filter-button {
      background: none;
      border: none;
      width: 100%;
      text-align: left;
      font-weight: bold;
      padding: 10px 0;
      color: #000;
    }
    .filter-button:focus {
      outline: none;
      box-shadow: none;
    }
    .job-card {
      transition: all 0.3s;
    }
    .job-card:hover {
      transform: translateY(-5px);
      box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
    }
  </style>
</head>

<body>

@include('layouts.navigation')
<section class="text-white py-5 position-relative overflow-hidden" style="background-color: #fcb045;">
  <div class="container position-relative z-2">
    <div class="row">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-3">
          Find Your Dream Job Here!
        </h1>
        <p class="lead">
          Search for jobs that match your skills and interests across various industries
        </p>
      </div>
    </div>
  </div>
</section>

<div class="container mt-4">
  <div class="d-flex mb-4 align-items-center" style="gap: 0.5rem;">
    <!-- Search form -->
    <form action="{{ route('job.show') }}" method="GET" class="d-flex flex-grow-1" style="gap: 0.5rem;">
      <input type="text" name="keyword" class="form-control" placeholder="Search by position or company..." value="{{ request()->get('keyword') }}">
      <button type="submit" class="btn btn-danger">Search</button>
    </form>

    <!-- Sort form -->
    <form method="GET" id="sortForm">
      @if(request()->has('keyword'))
        <input type="hidden" name="keyword" value="{{ request()->get('keyword') }}">
      @endif
      <select class="form-select" name="sort_by" onchange="document.getElementById('sortForm').submit()" style="min-width: 180px;">
        <option value="default" {{ request()->get('sort_by') == 'default' ? 'selected' : '' }}>Sort by Default</option>
        <option value="newest" {{ request()->get('sort_by') == 'newest' ? 'selected' : '' }}>Sort by Newest</option>
        <option value="oldest" {{ request()->get('sort_by') == 'oldest' ? 'selected' : '' }}>Sort by Oldest</option>
        <option value="recommended" {{ request()->get('sort_by') == 'recommended' ? 'selected' : '' }}>Recommended for You</option>
      </select>
    </form>
  </div>

  <div class="row">
    <div class="col-md-3">
      <div class="filter-section">
        <div class='mb-4 fs-4 fw-bold'>Filter and Sorting</div>
        <form action="{{ route('job.show') }}" method="GET">
          {{-- Location --}}
          <div class="mb-3">
            <label class="form-label fw-bold">Location</label>
            @if($locations->isNotEmpty())
              <select class="form-select select2" name="location[]" multiple>
                @foreach($locations as $location)
                  <option value="{{ $location }}" {{ collect(request('location'))->contains($location) ? 'selected' : '' }}>
                    {{ $location }}
                  </option>
                @endforeach
              </select>
            @else
              <div class="form-control text-muted">No locations available</div>
            @endif
          </div>
          
          {{-- Category --}}
          <div class="mb-3">
            <label class="form-label fw-bold">Category</label>
            @if($categories->isNotEmpty())
              <select class="form-select select2" name="categories[]" multiple>
                @foreach($categories as $categorie)
                  <option value="{{ $categorie->id }}" {{ collect(request('categories'))->contains($categorie->id) ? 'selected' : '' }}>
                    {{ $categorie->name }}
                  </option>
                @endforeach
              </select>
            @else
              <div class="form-control text-muted">No categories available</div>
            @endif
          </div>

          {{-- Salary --}}
          <div class="mb-3">
            <label class="form-label fw-bold">Salary</label>
            <div class="input-group mb-1">
              <input type="number" name="salary_min" class="form-control" placeholder="Min" value="{{ request('salary_min') }}">
              <input type="number" name="salary_max" class="form-control" placeholder="Max" value="{{ request('salary_max') }}">
            </div>
          </div>

          {{-- Experience --}}
          <div class="mb-3">
            <label class="form-label fw-bold">Experience (Years)</label>
            <div class="input-group mb-1">
              <input type="number" name="experience_min" class="form-control" placeholder="Min" value="{{ request('experience_min') }}">
              <input type="number" name="experience_max" class="form-control" placeholder="Max" value="{{ request('experience_max') }}">
            </div>
          </div>

          {{-- Skills --}}
          <div class="mb-3">
            <label class="form-label fw-bold">Skills</label>
            @if($skills->isNotEmpty())
              <select class="form-select select2" name="skills[]" multiple>
                @foreach($skills as $skill)
                  <option value="{{ $skill }}" {{ collect(request('skills'))->contains($skill) ? 'selected' : '' }}>
                    {{ $skill }}
                  </option>
                @endforeach
              </select>
            @else
              <div class="form-control text-muted">No skills available</div>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Apply Filter</button>
        </form>
      </div>
    </div>

    <div class="col-md-9">
      <div class="row">
        @foreach ($jobs as $job)
        <div class="col-md-6 mb-4">
          <div class="card shadow-sm rounded-4 h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="d-flex align-items-center">
                  @php
                      $avatar = optional($job->company?->profile)->avatar;
                      $avatarUrl = $avatar 
                          ? $avatar 
                          : 'https://via.placeholder.com/40';
                  @endphp

                  <img src="{{ $avatarUrl }}"
                      onerror="this.onerror=null;this.src='https://via.placeholder.com/40';"
                      alt="Logo"
                      width="40"
                      class="me-2 rounded-circle">

                  <div>
                    <strong class="d-block">{{ $job->company->profile->full_name ?? 'Unknown' }}</strong>
                    <small class="text-muted">{{ $job->location }}</small>
                  </div>
                </div>

                <div class="text-end">
                  <small class="text-muted mb-3">{{ $job->created_at->diffForHumans() }}</small><br>
                  @if ($job->category)
                    <span class="badge bg-warning text-dark">{{ $job->category->name }}</span>
                  @endif
                </div>
              </div>

              <h5 class="fw-bold">
                <a href="{{ route('job.detail', $job->id) }}" class="text-dark text-decoration-none">{{ $job->title }}</a>
              </h5>

              <div class="d-flex flex-wrap gap-2 mt-3 mb-3">
                @foreach ($job->skills as $skill)
                  <span class="badge bg-primary">{{ $skill }}</span>
                @endforeach
              </div>

              <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="d-flex flex-column align-items-start">
                  <span class="badge bg-warning mb-1">Salary</span>
                  <strong>Rp {{ number_format($job->salary_min, 0, ',', '.') }} - Rp {{ number_format($job->salary_max, 0, ',', '.') }}</strong>
                </div>

                @if (auth()->check() && auth()->user()->hasRole('pencarikerja'))
                  <form action="{{ route('job.apply', $job->id) }}" method="POST" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm px-3">Apply</button>
                  </form>
                @endif
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      width: '100%',
      placeholder: 'Select options',
      allowClear: true,
      dropdownParent: $('body')
    });
  });
</script>

</body>
</html>
