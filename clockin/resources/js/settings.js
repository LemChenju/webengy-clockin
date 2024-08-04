// settings.js

document.addEventListener("DOMContentLoaded", function() {
    // Dark Mode Einstellung anwenden
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    if (isDarkMode) {
        document.body.classList.add('dark-mode');
    }

    // Schriftgröße einstellen
    const fontSize = localStorage.getItem('fontSize') || '16';
    document.body.style.fontSize = fontSize + 'px';
});
