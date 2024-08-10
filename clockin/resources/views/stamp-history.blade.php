<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webengy Clockin - Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            background: #000000;
            overflow-x: hidden; /* Prevents horizontal scrolling */
        }
        .bg-image {
            background-size: cover;
            height: 100vh;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .buttons a, .buttons button {
            display: block;
            width: 100%;
            padding: 50px 100px;
            font-size: 3rem;
            color: #fff;
            background: linear-gradient(45deg, #1d2671, #c33764);
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .buttons a:hover, .buttons button:hover {
            background: linear-gradient(45deg, #c33764, #1d2671);
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        .btn-small {
            padding: 15px 30px;
            font-size: 1.5rem;
        }
        .datepicker {
            background-color: white;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .ui-datepicker {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .ui-datepicker-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            border-radius: 8px 8px 0 0;
            padding: 10px;
        }
        .ui-datepicker-calendar {
            margin: 10px 0;
        }
    </style>
</head>
<body>
<section class="bg-image py-3 py-md-5" style="background-image: url('https://laravel.com/assets/img/welcome/background.svg');">
    <div class="container py-4">
        <div class="p-5 mb-4 bg-light rounded-3 position-relative darkmodeChange">
            <h2 class="text-center darkmodeText">Stempelhistorie</h2>
            <h4 class="text-center darkmodeText">Bitte beachten, dass die Stempelhistorie nur bis zum gestrigen Tag angezeigt werden kann.
            <form id="stampHistoryForm" action="{{ route('generate-pdf') }}" method="POST" target="_blank">
                @csrf
                <div class="row justify-content-center darkmodeText">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Startdatum:</label>
                            <input type="text" id="start_date" name="start_date" class="form-control datepicker" placeholder="Startdatum" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">Enddatum:</label>
                            <input type="text" id="end_date" name="end_date" class="form-control datepicker" placeholder="Enddatum" required>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-4">
                    <div class="col-md-2 text-center">
                        <button type="submit" class="btn btn-primary">Bestätigen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

        $('#stampHistoryForm').on('submit', function(e) {
            var startDate = new Date($('#start_date').val());
            var endDate = new Date($('#end_date').val());
            var today = new Date();

            if (startDate > endDate) {
                alert('Das Startdatum darf nicht nach dem Enddatum liegen.');
                e.preventDefault();
            }

            if (endDate > today) {
                alert('Das Enddatum darf nicht in der Zukunft liegen.');
                e.preventDefault();
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Dark Mode Einstellung anwenden
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        if (isDarkMode) {
            const texts = document.querySelectorAll('.darkmodeText')
            texts.forEach(element => {
                element.classList.add("bg-dark");
                element.style.color = 'white';  // Textfarbe auf Weiß setzen
            });
            const backgrounds = document.querySelectorAll('.darkmodeChange')
            backgrounds.forEach(element => {
                element.classList.remove("bg-light");
                element.classList.add("bg-dark");
            })
        }
        const texts = document.querySelectorAll('.darkmodeText')
        texts.forEach(element => {
            const fontSize = localStorage.getItem('fontSize') || 1
            const originalSize = parseFloat(window.getComputedStyle(element).fontSize);
            element.style.fontSize = `${originalSize * fontSize}px`;
        });
    });
</script>
</body>
</html>
