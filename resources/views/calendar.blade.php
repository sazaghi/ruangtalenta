<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <title>Calendar</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #d1d5e8;
      padding: 2rem;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
    }

    h2 {
      margin-bottom: 35px;
      margin-top: 15px;
      font-weight: 800;
    }

    .calendar-card {
      background: white;
      border-radius: 15px;
      padding: 1.5rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    #monthYear {
        font-weight:600;
        margin-right: 10px;
        margin-left: 10px;
    }

    .calendar-header {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 1rem;
      margin-bottom: 35px;
      margin-top: 15px;
    }

    .calendar-header button {
      font-size: 1.5rem;
      background: none;
      border: none;
      cursor: pointer;
    }

    .calendar-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 0.5rem;
    }

    .day-name {
      text-align: center;
      font-weight: 400;
      margin-bottom: 0.5rem;
    }

    #calendarDays {
      display: contents;
    }

    .calendar-day {
      position: relative;
      border: 1px solid #000000;
      border-radius: 10px;
      text-align: center;
      width: 130px;
      height: 130px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-size: 0.85rem;
    }

    .calendar-day span {
        position: absolute;
        top: 4px;
        left: 4px;
        background-color: white;
        border-radius: 4px;
        padding: 2px 5px;
        font-size: 16px;
        font-weight: 600;  
    }

    .calendar-day small {
      font-size: 0.7rem;
      color: #333;
      text-align: end;
    }

    .inactive {
      background-color: #e0e0e0;
      color: #888;
    }

    @media (max-width: 768px) {
      .calendar-day {
        font-size: 0.75rem;
        width: 50px;
        height: 50px;
      }

      .calendar-day small {
        font-size: 0.6rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Calendar</h2>
    <div class="calendar-card">
      <div class="calendar-header">
        <button id="prevMonth">&larr;</button>
        <h3 id="monthYear">May 2025</h3>
        <button id="nextMonth">&rarr;</button>
      </div>
      <div class="calendar-grid">
        <div class="day-name">Sunday</div>
        <div class="day-name">Monday</div>
        <div class="day-name">Tuesday</div>
        <div class="day-name">Wednesday</div>
        <div class="day-name">Thursday</div>
        <div class="day-name">Friday</div>
        <div class="day-name">Saturday</div>
        <div id="calendarDays"></div>
      </div>
    </div>
  </div>

  <script>
    const calendarDays = document.getElementById("calendarDays");
    const monthYear = document.getElementById("monthYear");

    let currentDate = new Date(2025, 4, 1); // Mulai dari Mei 2025

    function renderCalendar(date) {
      const year = date.getFullYear();
      const month = date.getMonth();

      const firstDayOfMonth = new Date(year, month, 1);
      const lastDayOfMonth = new Date(year, month + 1, 0);
      const startDayIndex = firstDayOfMonth.getDay();
      const totalDaysInMonth = lastDayOfMonth.getDate();

      const prevMonthLastDate = new Date(year, month, 0).getDate();

      monthYear.textContent = date.toLocaleString("default", {
        month: "long",
        year: "numeric",
      });

      calendarDays.innerHTML = "";

      const totalCells = 35;
      const days = [];

      // Tanggal dari bulan sebelumnya
      for (let i = startDayIndex - 1; i >= 0; i--) {
        days.push({
          day: prevMonthLastDate - i,
          inactive: true,
        });
      }

      // Tanggal dari bulan sekarang
      for (let i = 1; i <= totalDaysInMonth; i++) {
        days.push({
          day: i,
          inactive: false,
        });
      }

      // Tanggal dari bulan berikutnya
      while (days.length < totalCells) {
        days.push({
          day: days.length - totalDaysInMonth - startDayIndex + 1,
          inactive: true,
        });
      }

      // Render ke DOM
      for (const d of days) {
        const dayCell = document.createElement("div");
        dayCell.classList.add("calendar-day");
        if (d.inactive) dayCell.classList.add("inactive");
        dayCell.innerHTML = `<span>${d.day}</span><small>18.00 - Int..</small>`;
        calendarDays.appendChild(dayCell);
      }
    }

    document.getElementById("prevMonth").addEventListener("click", () => {
      currentDate.setMonth(currentDate.getMonth() - 1);
      renderCalendar(currentDate);
    });

    document.getElementById("nextMonth").addEventListener("click", () => {
      currentDate.setMonth(currentDate.getMonth() + 1);
      renderCalendar(currentDate);
    });

    renderCalendar(currentDate);
  </script>
</body>
</html>
