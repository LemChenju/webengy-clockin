<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webengy Clockin - Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            background: #000000;
            overflow-x: hidden; /* Verhindert horizontales Scrollen */
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
    </style>
</head>
<body>
<section class="bg-image py-3 py-md-5" style="background-image: url('https://laravel.com/assets/img/welcome/background.svg');">
    <div class="container py-4">
        <div class="p-5 mb-4 bg-light rounded-3 position-relative darkmodeChange">
            <div class="header position-absolute top-0 end-0 mt-3 me-3">
            </div>
            <div class="container-fluid py-5 form-container">
                <div class="row mt-4">
                    <div class="col buttons mt-4">
                        <a href="{{ route('stamp-in') }}" class="btn btn-primary">Einstempeln</a>
                    </div>
                    <div class="col buttons mt-4">
                        <a href="{{ route('stamp-out') }}" class="btn btn-primary">Ausstempeln</a>
                    </div>
                </div>
                <div class="buttons mt-4">
                    <a href="{{ route('history') }}" class="btn btn-primary" style="padding: 15px 30px; font-size: 1.5rem;">Stempelhistorie Anzeigen</a>
                </div>
            </div>
            <!-- Rückkehr zum Dashboard -->
            <div class="mt-5 text-center darkmodeText">
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Zurück zum Dashboard</a>
            </div>
        </div>
    </div>
</section>

<!-- Füge FontAwesome und Bootstrap JS hinzu -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.2/js/bootstrap.min.js"></script>
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
