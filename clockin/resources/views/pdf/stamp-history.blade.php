<!DOCTYPE html>
<html>
<head>
    <title>Stamp History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .heading {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<h1 class="heading">Stempelhistorie</h1>

<p><strong>Startdatum:</strong> {{ $startDate }}</p>
<p><strong>Enddatum:</strong> {{ $endDate }}</p>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Eingestempelt</th>
        <th>Ausgestempelt</th>
    </tr>
    </thead>
    <tbody>
    @if(is_iterable($stamps) && count($stamps) > 0)
    @foreach ($stamps as $index => $stamp)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $stamp->stamped_in_at }}</td>
            <td>{{ $stamp->stamped_out_at }}</td>
        </tr>
    @endforeach
    @else
        <tr>
            <td colspan="3" class="text-center">Es wurden keine Stempelzeiten für den ausgewählten Zeitraum gefunden.</td>
        </tr>
    @endif
    </tbody>
</table>
</body>
</html>
