<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Tes</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .card {
            background-color: white;
            border-radius: 0;
            width: 200px;           /* lebar tetap */
            height: 200px;          /* tinggi tetap */
            padding: 20px;
            justify-content: space-between;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            display: flex;
            flex-direction: column;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #222;
        }

        .card-datetime {
            font-size: 13px;
            color: #555;
            margin-bottom: 10px;
        }

        .card-link {
            font-size: 13px;
            word-break: break-word;
            margin-bottom: 5px
        }

        .card-link a {
            color: #007bff;
            text-decoration: none;
        }

        .status-row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #333;
            margin-bottom: 10px
        }

        .status-icon-circle {
            width: 10px;
            height: 10px;
            background-color: red;
            border-radius: 50%;
        }

        .material-icons.black-icon {
            font-size: 16px;
            color: #000;
        }

        .cards-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
    </style>
</head>
<body>
    <div class="header">1 April 2025</div>

    <div class="cards-container">
        @foreach ($jadwals as $jadwal)
            <div class="card">
                <div>
                    <div class="card-title">{{ $jadwal->title }}</div>
                    <div class="card-datetime">
                        {{ \Carbon\Carbon::parse($jadwal->date)->format('Y.m.d') }} | {{ $jadwal->time }}
                    </div>
                    <div class="card-link">
                        🔗 <a href="{{ $jadwal->link }}" target="_blank">{{ $jadwal->link }}</a>
                    </div>
                </div>
                <div>
                    <div class="status-row">
                        <span class="material-icons black-icon">work</span>
                        <div>Busy</div>
                    </div>
                    <div class="status-row">
                        <div class="status-icon-circle"></div>
                        <div>On Progress</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>
