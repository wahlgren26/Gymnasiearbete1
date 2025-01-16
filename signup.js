document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.querySelector('input[type="password"]');
    const confirmPassword = document.querySelector('input[type="password"]:last-of-type');
    
    if (password.value !== confirmPassword.value) {
        e.preventDefault();
        alert('Lösenorden matchar inte!');
    }
}); 