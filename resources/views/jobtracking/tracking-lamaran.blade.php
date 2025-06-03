<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark">{{ __('My Job Applications') }}</h2>
    </x-slot>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    @endpush

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    @if ($lamarans->isEmpty())
                        <div class="alert alert-info text-center mb-0">No job applications submitted yet.</div>
                    @else
                        @php
                            function statusBadge($status) {
                                return match (strtolower($status)) {
                                    'pending' => '<span class="badge rounded-pill text-bg-warning"><i class="bi bi-clock me-1"></i> Pending</span>',
                                    'accepted' => '<span class="badge rounded-pill text-bg-success"><i class="bi bi-check-circle me-1"></i> Accepted</span>',
                                    'rejected' => '<span class="badge rounded-pill text-bg-secondary"><i class="bi bi-x-circle me-1"></i> Rejected</span>',
                                    default => '<span class="badge rounded-pill text-bg-light text-dark">'.ucfirst($status).'</span>',
                                };
                            }

                            function stageBadge($stage) {
                                return $stage
                                    ? '<i class="bi bi-check-circle text-success me-1"></i><strong>' . $stage . '</strong>'
                                    : '<span class="text-muted">Not yet in selection stage</span>';
                            }
                        @endphp

                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-light text-uppercase text-secondary small">
                                    <tr>
                                        <th>#</th>
                                        <th>Position</th>
                                        <th>Company</th>
                                        <th>Applied Date</th>
                                        <th>Status</th>
                                        <th>Selection Stage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lamarans as $index => $app)
                                        @php
                                            $appInterview = $interview->first(fn($intv) => $intv->post_kerjas_id === $app->post_kerjas_id);
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="fw-semibold">{{ $app->PostKerja->title }}</td>
                                            <td>{{ $app->PostKerja->company->name }}</td>
                                            <td>{{ $app->created_at->format('d M Y') }}</td>
                                            <td>{!! statusBadge($app->status) !!}</td>
                                            <td>{!! stageBadge($app->stages?->stage_name) !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
