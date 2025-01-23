document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    const submitButton = this.querySelector('.submit');
    submitButton.disabled = true;
    submitButton.classList.add('loading');
    
    // Här kan du lägga till din inloggningslogik senare
}); 