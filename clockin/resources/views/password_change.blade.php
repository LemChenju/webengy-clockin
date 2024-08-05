<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webengy Clockin - Passwort ändern</title>
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
        .form-group {
            width: 100%;
            max-width: 400px;
            margin-bottom: 15px;
        }
        .buttons a, .buttons button {
            display: block;
            width: 100%;
            padding: 10px 20px; /* Reduziere die Padding */
            font-size: 1rem; /* Reduziere die Schriftgröße */
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
    </style>
</head>
<body>
<section class="bg-image py-3 py-md-5" style="background-image: url('https://laravel.com/assets/img/welcome/background.svg');">
    <div class="container py-4">
        <div class="p-5 mb-4 bg-light rounded-3 position-relative darkmodeChange">
            <div class="container-fluid py-5 form-container">
                <h1 class="darkmodeText display-5 fw-bold">Passwort ändern</h1>
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label class="darkmodeText" for="old_password">Altes Passwort</label>
                        <input type="password" class="form-control" id="old_password" name="old_password" required>
                    </div>
                    <div class="form-group">
                        <label class="darkmodeText" for="new_password">Neues Passwort</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label class="darkmodeText" for="new_password_confirmation">Neues Passwort wiederholen</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                    <div class="buttons mt-4 darkmodeText">
                        <button type="submit" class="btn">Passwort ändern</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Füge Bootstrap JS hinzu -->
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.2/js/bootstrap.min.js"></script>
</body>
</html>
