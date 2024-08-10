<?php
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['startDate']) && isset($_POST['endDate']) && isset($_POST['reason'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $reason = $_POST['reason'];

    $userId = auth()->id();

    DB::table('stamps')->insert(
        array(
            'user_id'     =>   $userId,
            'start_date'   =>   $startDate,
            'end_date'  =>  $endDate,
            'reason'    =>  $reason
        )
    );

    $successMessage = 'Urlaub beantragt!';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['month'])) {
    $currentMonth = $_POST['month'];
} else {
    $currentMonth = date('Y-m');
}

$monthName = date('F Y', strtotime($currentMonth));
$firstDayOfMonth = date('Y-m-01', strtotime($currentMonth));
$lastDayOfMonth = date('Y-m-t', strtotime($currentMonth));
$firstDayOfWeek = date('N', strtotime($firstDayOfMonth));
$lastDayOfWeek = date('N', strtotime($lastDayOfMonth));

$prevMonthDays = [];
$nextMonthDays = [];

$prevMonth = date('Y-m', strtotime($currentMonth . ' -1 month'));
$prevMonthLastDay = date('Y-m-t', strtotime($prevMonth));
$daysInPrevMonth = date('d', strtotime($prevMonthLastDay));
for ($i = $daysInPrevMonth - $firstDayOfWeek + 2; $i <= $daysInPrevMonth; $i++) {
    $prevMonthDays[] = $i;
}

$nextMonth = date('Y-m', strtotime($currentMonth . ' +1 month'));
for ($i = 1; $i <= 7 - $lastDayOfWeek; $i++) {
    $nextMonthDays[] = $i;
}

$calendarData = [
    'monthName' => $monthName,
    'prevMonthDays' => $prevMonthDays,
    'currentMonthDays' => range(1, date('t', strtotime($currentMonth))),
    'nextMonthDays' => $nextMonthDays,
    'prevMonth' => $prevMonth,
    'nextMonth' => $nextMonth
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajax'])) {
    echo json_encode($calendarData);
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <style>
        /* Style für die gesamte Seite */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: row; /* Horizontaler Verlauf */
        }

        .left-panel {
            width: 25%; /* Breite des linken Panels */
            padding: 30px;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box; /* Stellt sicher, dass Padding und Border in der Breite enthalten sind */
        }

        .form-container {
            max-width: 300px;
            width: 100%;
        }

        .right-panel {
            width: 75%; /* Breite des rechten Panels */
            padding: 30px;
            background-color: #ffffff;
            display: flex;
            flex-direction: column; /* Vertikaler Verlauf */
        }

        .month-container {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Platz zwischen Elementen */
            margin-bottom: 20px; /* Abstand zu folgendem Inhalt */
        }

        .month-controls {
            display: flex;
            align-items: center;
            background-color: #ffffff; /* Hintergrund auf Weiß */
            border: 1px solid #dee2e6; /* Dünner grauer Rand */
            border-radius: 25px; /* Halbkreis-Ränder für die Seiten */
            padding: 0 10px; /* Padding für einheitliche Größe */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 220px; /* Feste Breite für einheitliche Größe */
            height: 40px; /* Höhe des Containers */
        }

        .month-controls button {
            background: none;
            border: none;
            font-size: 1.2rem; /* Etwas kleinere Schriftgröße */
            cursor: pointer;
            color: #007bff;
        }

        .month-controls span {
            flex: 1; /* Span nimmt den gesamten verfügbaren Platz */
            text-align: center; /* Zentriert den Text */
            margin: 0; /* Kein Abstand */
            font-weight: bold;
            font-size: 1rem; /* Schriftgröße für den Monat */
        }

        .month-controls button:hover {
            color: #0056b3;
        }

        .month-controls .btn-month {
            padding: 0;
            width: 30px; /* Breite der Buttons */
            height: 30px; /* Höhe der Buttons */
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%; /* Halbkreis-Ränder */
        }

        .current-month-container {
            display: flex;
            align-items: center;
            margin-left: 10px; /* Abstand zum Monatswechsel-Button */
        }

        .current-month-button {
            background-color: #ffffff; /* Weißer Hintergrund */
            border: 1px solid #dee2e6; /* Dünner grauer Rand */
            border-radius: 50%; /* Rund */
            width: 40px; /* Breite des Buttons */
            height: 40px; /* Höhe des Buttons */
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            color: #007bff;
        }

        .current-month-button:hover {
            color: #0056b3;
        }

        .btn-month:focus {
            outline: none; /* Entfernt den Fokus-Rand */
        }

        /* Style für den Kalender */
        .calendar {
            border: 1px solid #dee2e6; /* Dünner grauer Rand */
            border-radius: 10px; /* Runde Ecken für den Kalender */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .calendar .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            text-align: center;
            font-weight: bold;
        }

        .calendar .calendar-header div {
            padding: 15px; /* Größeres Padding für bessere Sichtbarkeit */
            border-right: 1px solid #dee2e6; /* Graues Raster zwischen den Wochentagen */
        }

        .calendar .calendar-header div:last-child {
            border-right: none; /* Kein Rand am rechten Rand des Headers */
        }

        .calendar .calendar-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-top: 1px solid #dee2e6; /* Graue Linie oben */
        }

        .calendar .calendar-body div {
            position: relative;
            text-align: center;
            padding: 10px; /* Padding für besseren Platz */
            height: 80px; /* Höhe der Kalender-Zellen */
            border-right: 1px solid #dee2e6; /* Graues Raster zwischen den Tagen */
            border-bottom: 1px solid #dee2e6; /* Graues Raster zwischen den Tagen */
        }

        .calendar .calendar-body div:last-child {
            border-right: none; /* Kein Rand am rechten Rand der Zellen */
        }

        .calendar .calendar-body .prev-month,
        .calendar .calendar-body .next-month {
            color: #6c757d; /* Graue Farbe für die Tage des vorherigen und nächsten Monats */
            background-color: #f0f0f0; /* Hellgrauer Hintergrund für die Tage des vorherigen und nächsten Monats */
        }

        .calendar .calendar-body .current-month {
            background-color: #ffffff;
        }

        .calendar .calendar-body .current-month:hover {
            background-color: #e9ecef; /* Hellgrauer Hintergrund beim Hover-Effekt */
            cursor: pointer; /* Zeigt an, dass es klickbar ist */
        }

        .calendar .calendar-body .day-number {
            position: absolute;
            top: 5px;
            left: 5px;
            font-weight: bold;
            font-size: 0.8rem; /* Kleinere Schriftgröße für die Tagesnummer */
            display: flex; /* Flexbox für zentrierte Ausrichtung */
            align-items: center; /* Vertikale Zentrierung */
            justify-content: center; /* Horizontale Zentrierung */
            width: 28px; /* Konstante Breite */
            height: 28px; /* Konstante Höhe */
            border-radius: 50%; /* Rund */
            background-color: transparent; /* Transparenter Hintergrund */
        }

        .calendar .calendar-body .selected .day-number {
            background-color: #c3e6cb; /* Hellerer Grünton für die Tageszahl */
            color: #155724; /* Dunkelgrüne Schriftfarbe */
        }

        .calendar .calendar-body .range .day-number {
            background-color: #ffeeba; /* Heller Gelbton für die Range */
            color: #856404; /* Dunkler Gelbton für die Schrift */
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urlaub beantragen</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="./../css/holiday.css" rel="stylesheet">
</head>
<body>
<div class="left-panel">
    <div class="form-container" method="POST" action="{{ route('holiday') }}">

        <h5>Urlaub beantragen</h5>
        <form method="POST" action="{{ route('holiday') }}">
            @csrf
            <div class="form-group">
                <label for="startDate">Anfangsdatum</label>
                <input type="date" class="form-control" id="startDate" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="endDate">Enddatum</label>
                <input type="date" class="form-control" id="endDate" name="end_date" required>
            </div>
            <div class="form-group">
                <label for="reason">Grund</label>
                <input type="text" class="form-control" id="reason" name="reason" placeholder="Gib den Grund ein" required>
            </div>
            <button class="btn btn-primary" type="submit">Absenden</button>
        </form>
    </div>
</div>
<div class="right-panel">
    <h1>Urlaubsplanung</h1>
    </br>
    <div class="month-container">
        <form method="post" action="" class="month-controls">
            <button name="prevMonth" class="btn-month">&lt;</button>
            <span id="monthName"><?php echo $monthName; ?></span>
            <button name="nextMonth" class="btn-month">&gt;</button>
            <input type="hidden" name="currentMonth" value="<?php echo htmlspecialchars($currentMonth); ?>">
        </form>
        <form method="post" action="" class="current-month-container">
            <button name="currentMonthButton" class="current-month-button">◉</button>
        </form>
    </div>

    <div class="calendar">
        <div class="calendar-header">
            <div>Montag</div>
            <div>Dienstag</div>
            <div>Mittwoch</div>
            <div>Donnerstag</div>
            <div>Freitag</div>
            <div>Samstag</div>
            <div>Sonntag</div>
        </div>
        <div class="calendar-body" id="calendarBody"></div>
    </div>

    <?php if ($successMessage): ?>
    <p><?php echo $successMessage; ?></p>
    <?php endif; ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarBody = document.getElementById('calendarBody');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');
        let startDateSelected = false;
        let startDate = null;
        let endDate = null;

        function updateCalendar() {
            const currentMonth = document.querySelector('input[name="currentMonth"]').value;
            fetch('holiday.blade.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    ajax: true,
                    month: currentMonth
                })
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('monthName').textContent = data.monthName;
                    calendarBody.innerHTML = '';

                    // Vorherige Monate
                    data.prevMonthDays.forEach(day => {
                        const div = document.createElement('div');
                        div.classList.add('prev-month');
                        div.setAttribute('data-date', `${data.prevMonth}-${String(day).padStart(2, '0')}`);
                        div.innerHTML = `<span class="day-number">${day}</span>`;
                        calendarBody.appendChild(div);
                    });

                    // Aktueller Monat
                    data.currentMonthDays.forEach(day => {
                        const div = document.createElement('div');
                        div.classList.add('current-month');
                        div.setAttribute('data-date', `${currentMonth}-${String(day).padStart(2, '0')}`);
                        div.innerHTML = `<span class="day-number">${day}</span>`;
                        calendarBody.appendChild(div);
                    });

                    // Nächste Monate
                    data.nextMonthDays.forEach(day => {
                        const div = document.createElement('div');
                        div.classList.add('next-month');
                        div.setAttribute('data-date', `${data.nextMonth}-${String(day).padStart(2, '0')}`);
                        div.innerHTML = `<span class="day-number">${day}</span>`;
                        calendarBody.appendChild(div);
                    });
                    markCalendarRange();
                });

        }

        function markCalendarRange() {
            const start = new Date(startDate);
            const end = new Date(endDate);
            const calendarDays = document.querySelectorAll('.calendar-body div[data-date]');
            calendarDays.forEach(d => {
                const dDate = new Date(d.getAttribute('data-date'));
                if (dDate >= start && dDate <= end) {
                    d.classList.add('range');
                } else {
                    d.classList.remove('range');
                }
            });
        }

        function markSelectedDate(date, type) {
            const calendarDays = document.querySelectorAll('.calendar-body div[data-date]');
            calendarDays.forEach(d => {
                if (d.getAttribute('data-date') === date) {
                    d.classList.add(type);
                } else {
                    d.classList.remove(type);
                }
            });
        }

        calendarBody.addEventListener('click', function(e) {
            const day = e.target.closest('div[data-date]');
            if (day) {
                const date = day.getAttribute('data-date');
                const [year, month, dayNumber] = date.split('-');
                const formattedDate = `${year}-${month}-${dayNumber.padStart(2, '0')}`;

                if (!startDateSelected) {
                    startDate = formattedDate;
                    endDate = null;
                    startDateInput.value = formattedDate;
                    endDateInput.value = null;
                    startDateSelected = true;
                    markSelectedDate(formattedDate, 'selected');
                    markCalendarRange();
                } else {
                    if (new Date(formattedDate) < new Date(startDate)) {
                        endDate = startDate;
                        startDate = formattedDate;
                        startDateInput.value = startDate;
                        endDateInput.value = endDate;
                    } else {
                        endDate = formattedDate;
                        endDateInput.value = endDate;
                    }

                    startDateSelected = false;
                    markCalendarRange();
                }
            }
        });

        startDateInput.addEventListener('change', function() {
            startDate = this.value;
            startDateSelected = true;
            markSelectedDate(startDate, 'selected');
            markCalendarRange();
        });

        endDateInput.addEventListener('change', function() {
            endDate = this.value;
            markCalendarRange();
        });

        document.querySelector('[name="prevMonth"]').addEventListener('click', function(e) {
            e.preventDefault();
            const currentMonth = document.querySelector('input[name="currentMonth"]').value;
            const [year, month] = currentMonth.split('-').map(Number);

            // Erstelle ein Datum für den ersten Tag des aktuellen Monats
            const newMonth = new Date(year, month);

            // Setze den Monat auf den nächsten Monat
            newMonth.setMonth(newMonth.getMonth() - 1);

            // Formatiere das Datum im Format "YYYY-MM"
            const newMonthStr = newMonth.toISOString().slice(0, 7);

            // Aktualisiere das Eingabefeld mit dem neuen Monat
            document.querySelector('input[name="currentMonth"]').value = newMonthStr;

            // Aktualisiere den Kalender oder führe andere notwendige Funktionen aus
            updateCalendar();
        });

        document.querySelector('[name="nextMonth"]').addEventListener('click', function(e) {
            e.preventDefault();
            const currentMonth = document.querySelector('input[name="currentMonth"]').value;
            const [year, month] = currentMonth.split('-').map(Number);

            // Erstelle ein Datum für den ersten Tag des aktuellen Monats
            const newMonth = new Date(year, month);

            // Setze den Monat auf den nächsten Monat
            newMonth.setMonth(newMonth.getMonth() + 1);

            // Formatiere das Datum im Format "YYYY-MM"
            const newMonthStr = newMonth.toISOString().slice(0, 7);

            // Aktualisiere das Eingabefeld mit dem neuen Monat
            document.querySelector('input[name="currentMonth"]').value = newMonthStr;

            // Aktualisiere den Kalender oder führe andere notwendige Funktionen aus
            updateCalendar();
        });

        document.querySelector('[name="currentMonthButton"]').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('input[name="currentMonth"]').value = new Date().toISOString().slice(0, 7);
            updateCalendar();
        });

        updateCalendar();
    });
</script>

</body>
</html>
