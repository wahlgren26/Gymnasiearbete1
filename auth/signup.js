document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.querySelector('input[name="password"]');
    const confirmPassword = document.querySelector('input[name="confirm_password"]');
    
    if (password.value !== confirmPassword.value) {
        e.preventDefault();
        alert('Lösenorden matchar inte!');
        return;
    }
    
    const submitButton = this.querySelector('.submit');
    submitButton.disabled = true;
    submitButton.classList.add('loading');
});