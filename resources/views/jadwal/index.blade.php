<x-app-layout>
    <x-slot name="header">
        <h2 class="text-left mb-6" style="font-family: 'Roboto', sans-serif; font-size: 30px;">
            {{ __('Jadwal Interview') }}
        </h2>
    </x-slot>

    @php
        $now = \Carbon\Carbon::now();
        $month = $now->month;
        $year = $now->year;
        $startDay = \Carbon\Carbon::create($year, $month, 1)->startOfMonth()->dayOfWeek; // 0 = Sunday
        $totalDays = \Carbon\Carbon::create($year, $month, 1)->daysInMonth;
    @endphp

    <style>
        body {
            background-color: #d9dcf0;
        }

        .calendar-container {
            border-radius: 16px;
            padding: 30px;
            background: #fff;
            max-width: 100%;
            margin: 0 auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 12px;
        }

        .day-cell {
            background-color: white;
            border: var(--border-thickness, 1px) solid #e1e1e1;
            border-radius: 12px;
            padding: 10px;
            min-height: 100px;
            font-size: 14px;
            position: relative;
            text-align: left;
            color: #000;
            transition: 0.2s ease;
        }

        .day-cell:hover {
            background-color: #f1f5fb;
            cursor: pointer;
        }

        .day-cell.disabled {
            background-color: #e1e1e1;
        }

        .day-cell strong {
            position: absolute;
            top: 8px;
            left: 8px;
            background: #eee;
            padding: 2px 6px;
            border-radius: 6px;
            font-size: 13px;
        }

        .schedule {
            display: block;
            font-size: 13px;
            margin-top: 40px;
            color: #000;
        }

        .Interview {
            background-color: #D3D8EB;
            color: #1a237e;
            border-radius: 12px;
        }

        .day-names {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>

    <div class="calendar-container mt-4">
        <div class="calendar-header">
            <button class="btn btn-primary" onclick="prevMonth()">&lt;</button>
            <h4 id="calendarTitle" class="fw-bold mb-0">{{ $now->format('F Y') }}</h4>
            <div>
                <button class="btn btn-primary" onclick="goToday()">Today</button>
            </div>
        </div>

        <div class="day-names">
            <div>Sunday</div>
            <div>Monday</div>
            <div>Tuesday</div>
            <div>Wednesday</div>
            <div>Thursday</div>
            <div>Friday</div>
            <div>Saturday</div>
        </div>

        <div class="calendar-grid" id="calendar-grid">
            {{-- Kosongkan cell sampai tanggal 1 --}}
            @for ($i = 0; $i < $startDay; $i++)
                <div class="day-cell disabled"></div>
            @endfor

            {{-- Isi tanggal dan event --}}
            @for ($day = 1; $day <= $totalDays; $day++)
                @php
                    $dateStr = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
                    $dayEvents = collect($events)->where('date', $dateStr);
                @endphp
                <div class="day-cell" onclick="showDetails('{{ $dateStr }}')">
                    <strong>{{ $day }}</strong>
                    @php
                        $eventCount = $dayEvents->count();
                    @endphp

                    @if ($eventCount > 0)
                        <span class="schedule Interview">
                            {{ $dayEvents->first()['time'] }} - {{ $dayEvents->first()['title'] }}
                        </span>
                        @if ($eventCount > 1)
                            <div class="mt-1 text-primary small" style="cursor: pointer;" onclick="showDetails('{{ $dateStr }}')">
                                +{{ $eventCount - 1 }} lainnya
                            </div>
                        @endif
                    @endif
                </div>
            @endfor
        </div>
    </div>

    <!-- Modal untuk detail jadwal -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id='modalDate'></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="modalEvents" class="list-unstyled"></ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        const events = @json($events);
        const calendarTitle = document.getElementById("calendarTitle");
        const calendarGrid = document.getElementById("calendar-grid");

        let current = new Date();

        function renderCalendar(year, month) {
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDayOfWeek = firstDay.getDay();
            const totalDays = lastDay.getDate();

            calendarTitle.innerText = firstDay.toLocaleString('default', { month: 'long', year: 'numeric' });
            calendarGrid.innerHTML = "";

            for (let i = 0; i < startDayOfWeek; i++) {
                const emptyCell = document.createElement("div");
                emptyCell.classList.add("day-cell", "disabled");
                calendarGrid.appendChild(emptyCell);
            }

            for (let day = 1; day <= totalDays; day++) {
                const cell = document.createElement("div");
                cell.classList.add("day-cell");
                const dateStr = `${year}-${(month + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                const todayEvents = events.filter(e => e.date === dateStr);

                cell.innerHTML = `<strong>${day}</strong>`;
                if (todayEvents.length > 0) {
                    const first = todayEvents[0];
                    cell.innerHTML += `<span class="schedule Interview">${first.time} - ${first.title}</span>`;

                    if (todayEvents.length > 1) {
                        const extraCount = todayEvents.length - 1;
                        cell.innerHTML += `<div class="mt-1 text-primary small" style="cursor:pointer;" onclick="showDetails('${dateStr}')">+${extraCount} lainnya</div>`;
                    }
                }

                cell.onclick = () => showDetails(dateStr);
                calendarGrid.appendChild(cell);
            }
        }

        function showDetails(date) {
            const selectedEvents = events.filter(event => event.date === date);
            document.getElementById('modalDate').innerText = 'Jadwal untuk: ' + date;

            let eventList = '';

            selectedEvents.forEach(event => {
                eventList += `
                    <li class="mb-2">
                        <div class="card">
                            <div class="card-header">${event.title}</div>
                            <div class="card-body">
                                <p class="text-muted mb-3">${event.time}</p>
                                <p class="mb-2 d-flex align-items-center">
                                    <i class="bi bi-link-45deg me-2"></i>
                                    <a href="${event.link}" target="_blank" class="text-decoration-underline text-primary small">Link Interview</a>
                                </p>
                                <p class="mb-3 d-flex align-items-center">
                                    <span class="me-2 rounded-circle bg-danger" style="width: 10px; height: 10px;"></span>
                                    <span class="small fw-semibold">${event.status}</span>
                                </p>
                                <div class="small">
                                    <p class="fw-semibold mb-1">Catatan:</p>
                                    ${event.result_note 
                                        ? `<div class="bg-light p-2 rounded border">${event.result_note}</div>` 
                                        : `
                                            <form action="/interview/${event.id}/note" method="POST" class="mt-1">
                                                @csrf
                                                @method('PUT')
                                                <textarea name="result_note" rows="2" class="form-control mb-1" placeholder="Tulis catatan..."></textarea>
                                                <button type="submit" class="btn btn-sm btn-success">Simpan Catatan</button>
                                            </form>
                                        `
                                    }
                                </div>
                            </div>
                        </div>
                    </li>
                `;
            });

            document.getElementById('modalEvents').innerHTML = eventList;
            const modal = new bootstrap.Modal(document.getElementById('scheduleModal'));
            modal.show();
        }

        function prevMonth() {
            current.setMonth(current.getMonth() - 1);
            renderCalendar(current.getFullYear(), current.getMonth());
        }

        function goToday() {
            current = new Date();
            renderCalendar(current.getFullYear(), current.getMonth());
        }

        renderCalendar(current.getFullYear(), current.getMonth());
    </script>
</x-app-layout>
