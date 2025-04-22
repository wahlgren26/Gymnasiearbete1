// Låt formuläret skickas normalt utan att förhindra det
// Vi behöver ingen JavaScript-kod som förhindrar det

// Om vi vill ha animationseffekter kan vi göra så här
document.querySelector('form').addEventListener('submit', function() {
    const submitButton = this.querySelector('.submit');
    submitButton.disabled = true;
    submitButton.classList.add('loading');
    // Formuläret kommer att skickas som vanligt
}); 