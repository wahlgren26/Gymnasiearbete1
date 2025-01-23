document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.querySelector('input[type="password"]');
    const confirmPassword = document.querySelector('input[type="password"]:last-of-type');
    
    if (password.value !== confirmPassword.value) {
        e.preventDefault();
        alert('Lösenorden matchar inte!');
    }
}); 

const form = document.querySelector('form');
form.addEventListener('submit', function(e) {
    const submitButton = this.querySelector('.submit');
    submitButton.disabled = true;
    submitButton.classList.add('loading');
});