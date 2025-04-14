<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark">
            {{ __('Tracking Lamaran') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">Daftar Lamaran Saya</h5>

                    @if ($lamarans->isEmpty())
                        <div class="alert alert-info text-center">
                            Belum ada lamaran yang diajukan.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Posisi</th>
                                        <th>Status</th>
                                        <th>Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lamarans as $app)
                                        <tr>
                                            <td>{{ $app->PostKerja->title }}</td>
                                            <td>
                                                <span class="badge 
                                                    {{ $app->status == 'pending' ? 'bg-warning text-dark' : '' }}
                                                    {{ $app->status == 'reviewed' ? 'bg-primary' : '' }}
                                                    {{ $app->status == 'interview' ? 'bg-success' : '' }}
                                                    {{ $app->status == 'accepted' ? 'bg-purple text-white' : '' }}
                                                    {{ $app->status == 'rejected' ? 'bg-danger' : '' }}">
                                                    {{ ucfirst($app->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $app->created_at->format('d M Y') }}</td>
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
