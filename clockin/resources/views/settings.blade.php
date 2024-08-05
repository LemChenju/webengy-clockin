<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="darkmodeText">Einstellungen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            transition: background-color 0.3s, color 0.3s;
        }
        .dark-mode {
            background-color: #121212;
            color: #ffffff;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="display-5 fw-bold text-center mb-5 darkmodeText">Einstellungen</h1>
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="darkModeToggle">
        <label class="form-check-label" for="darkModeToggle darkmodeText">Dark Mode</label>
    </div>
    <div class="mt-4">
        <label for="fontSizeRange" class="form-label darkmodeText">Schriftgröße</label>
        <input type="range" class="form-range" min="0.5" max="2" step="0.1" value="1" id="fontSizeRange">
    </div>

    <!-- Rückkehr zum Dashboard -->
    <div class="mt-5 text-center darkmodeText">
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Zurück zum Dashboard</a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Dark Mode Einstellung anwenden
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        if (isDarkMode) {
            document.body.classList.add('dark-mode');
        }

        // Schriftgröße einstellen
        const fontSize = localStorage.getItem('fontSize') || '1';
        document.body.style.fontSize = fontSize;

        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        darkModeToggle.checked = isDarkMode;
        darkModeToggle.addEventListener('change', function() {
            if (darkModeToggle.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('darkMode', 'true');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', 'false');
            }
        });

        // Schriftgrößenänderung
        const fontSizeRange = document.getElementById('fontSizeRange');
        fontSizeRange.value = fontSize;
        fontSizeRange.addEventListener('input', function() {
            const newSize = fontSizeRange.value;
            const texts = document.querySelectorAll('.darkmodeText')
            texts.forEach(element => {
                const originalSize = parseFloat(window.getComputedStyle(element).fontSize);
                element.style.fontSize = `${originalSize * newSize}px`;
            });
        });
    });
</script>

</body>
</html>
