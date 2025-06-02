<h2>{{ $user->profile->full_name ?? $user->name }}</h2>
<p><strong>Email:</strong> {{ $user->email }}</p>
<p><strong>Nomor Kontak:</strong> {{ $user->profile->contact_number }}</p>
<p><strong>Alamat:</strong> {{ $user->profile->complete_address }}</p>
<p><strong>Skor Lamaran:</strong> {{ $lamaran->score ?? '-' }}</p>
<p><strong>Bio:</strong> {{ $user->profile->bio }}</p>

<h3>Pendidikan</h3>
@foreach ($user->educations as $edu)
    <p>{{ $edu->degree }} di {{ $edu->institution }} ({{ $edu->start_year }} - {{ $edu->end_year }})</p>
@endforeach

<h3>Pengalaman Kerja</h3>
@foreach ($user->workExperiences as $exp)
    <p>{{ $exp->position }} di {{ $exp->company }} ({{ $exp->start_date }} - {{ $exp->end_date }})</p>
@endforeach

<h3>Berkas</h3>
@if ($lamaran)
    @if ($lamaran->resume_path)
        <a href="{{ asset('storage/' . $lamaran->resume_path) }}" target="_blank">Download CV</a><br>
    @endif
    @if ($lamaran->application_letter_path)
        <a href="{{ asset('storage/' . $lamaran->application_letter_path) }}" target="_blank">Download Surat Lamaran</a><br>
    @endif
    @if ($lamaran->portfolio_link)
        <a href="{{ $lamaran->portfolio_link }}" target="_blank">Lihat Portofolio</a><br>
    @endif
@endif
