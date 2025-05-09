function validatePasswords() {
    const password = document.querySelector('input[name="password"]').value;
    const repeatPassword = document.querySelector('input[name="repeat"]').value;
    const errorMessage = document.getElementById('error-message');

    if (password !== repeatPassword) {
        errorMessage.textContent = "Passwords do not match. Please try again.";
        errorMessage.style.display = 'block'; // Show error message
        
        return false; // Prevent form submission
    }
    errorMessage.style.display = 'none'; // Hide error message if passwords match
    return true; 
}