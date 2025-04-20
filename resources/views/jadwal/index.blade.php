<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-bold text-dark">
            {{ __('Jadwal Interview') }}
        </h2>
    </x-slot>

    @php
        $startDay = \Carbon\Carbon::create(2025, 4, 1)->startOfMonth()->dayOfWeek; // 0 = Sunday
        $totalDays = \Carbon\Carbon::create(2025, 4, 1)->daysInMonth;
    @endphp

    <style>
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }
        .day-cell {
            border: 1px solid #ccc;
            min-height: 100px;
            padding: 6px;
            font-size: 13px;
            vertical-align: top;
            background-color: #f9f9f9;
        }
        .schedule {
            display: block;
            padding: 2px 4px;
            border-radius: 4px;
            font-size: 12px;
            margin-top: 4px;
            color: white;
        }
        .Friend { background: #28a745; }
        .My { background: #007bff; }
        .Company { background: #0d6efd; }
        .Family { background: #dc3545; }
        .Travel { background: #ffc107; color: black; }
    </style>

    <div class="calendar-grid mt-3">
        {{-- Kosongkan cell sampai tanggal 1 --}}
        @for ($i = 0; $i < $startDay; $i++)
            <div class="day-cell"></div>
        @endfor

        {{-- Isi tanggal dan event --}}
        @for ($day = 1; $day <= $totalDays; $day++)
            @php
                $dateStr = \Carbon\Carbon::create(2025, 4, $day)->format('Y-m-d');
                $dayEvents = collect($events)->where('date', $dateStr);
            @endphp
            <div class="day-cell" onclick="showDetails('{{ $dateStr }}')">
                <strong>{{ $day }}</strong>
                @foreach ($dayEvents as $event)
                    <span class="schedule {{ $event['type'] }}">
                        {{ $event['time'] }} - {{ $event['title'] }}
                    </span>
                @endforeach
            </div>
        @endfor
    </div>

    <!-- Modal untuk detail jadwal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Jadwal Hari Ini</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 id="modalDate"></h6>
                    <ul id="modalEvents">
                        <!-- Daftar event akan dimuat di sini -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetails(date) {
        const events = @json($events);
        const selectedEvents = events.filter(event => event.date === date);

        document.getElementById('modalDate').innerText = 'Jadwal untuk: ' + date;

        let eventList = '';

        selectedEvents.forEach(event => {
            eventList += `
            <li class="mb-2">
                <strong>${event.time}</strong>: ${event.title}
                ${event.link ? `<a href="${event.link}" target="_blank" class="btn btn-sm btn-info ms-2">Lihat Link</a>` : ''}
                <form action="/interview/${event.id}/note" method="POST" class="mt-1">
                    @csrf
                    <textarea name="result_note" rows="2" class="form-control mb-1" placeholder="Tulis catatan...">${event.result_note ?? ''}</textarea>
                    <button type="submit" class="btn btn-sm btn-success">Simpan Catatan</button>
                </form>
            </li>
            `;
        });

        document.getElementById('modalEvents').innerHTML = eventList;

        const modal = new bootstrap.Modal(document.getElementById('scheduleModal'));
        modal.show();
    }

    </script>

</x-app-layout>
