// app.js

// Function to toggle dark mode
function toggleDarkMode() {
    const body = document.body;
    const toggleButton = document.getElementById('darkModeToggle');

    body.classList.toggle('dark-mode');

    // Change the button emoji
    if (body.classList.contains('dark-mode')) {
        toggleButton.innerHTML = '🌙';  // Moon for dark mode
        localStorage.setItem('theme', 'dark');
    } else {
        toggleButton.innerHTML = '☀️';  // Sun for light mode
        localStorage.setItem('theme', 'light');
    }
}

// Check for saved user preference on page load
window.onload = function() {
    const theme = localStorage.getItem('theme');
    const toggleButton = document.getElementById('darkModeToggle');

    if (theme === 'dark') {
        document.body.classList.add('dark-mode');
        toggleButton.innerHTML = '🌙';  // Moon for dark mode
    } else {
        toggleButton.innerHTML = '☀️';  // Sun for light mode
    }
};

// Attach the function to the button
document.getElementById('darkModeToggle').addEventListener('click', toggleDarkMode);
