<?php
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['startDate']) && isset($_POST['endDate']) && isset($_POST['reason'])) {
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
    <script src="./../js/holiday.js"></script>
</body>
</html>
