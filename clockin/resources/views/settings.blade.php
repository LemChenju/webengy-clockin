<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Einstellungen</title>
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
    <h1 class="display-5 fw-bold text-center mb-5">Einstellungen</h1>
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="darkModeToggle">
        <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
    </div>
    <div class="mt-4">
        <label for="fontSizeRange" class="form-label">Schriftgröße</label>
        <input type="range" class="form-range" min="14" max="24" id="fontSizeRange">
    </div>
</div>

<script>
    // Setzen der Standardwerte beim Laden der Seite
    document.addEventListener("DOMContentLoaded", function() {
        // Dark Mode Toggle Zustand
        const darkModeToggle = document.getElementById('darkModeToggle');
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        darkModeToggle.checked = isDarkMode;
        if (isDarkMode) {
            document.body.classList.add('dark-mode');
        }

        // Schriftgröße einstellen
        const fontSizeRange = document.getElementById('fontSizeRange');
        const fontSize = localStorage.getItem('fontSize') || '16';
        document.body.style.fontSize = fontSize + 'px';
        fontSizeRange.value = fontSize;

        // Event Listener für Dark Mode Toggle
        darkModeToggle.addEventListener('change', function() {
            if (darkModeToggle.checked) {
                document.body.classList.add('dark-mode');
                localStorage.setItem('darkMode', 'true');
            } else {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', 'false');
            }
        });

        // Event Listener für Schriftgrößenänderung
        fontSizeRange.addEventListener('input', function() {
            const newSize = fontSizeRange.value;
            document.body.style.fontSize = newSize + 'px';
            localStorage.setItem('fontSize', newSize);
        });
    });
</script>

</body>
</html>
