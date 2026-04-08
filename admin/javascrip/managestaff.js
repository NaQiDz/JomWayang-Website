// Password Validation Function
function validatePassword(password) {
    const lengthCheck = password.length >= 10; 
    const uppercaseCheck = /[A-Z]/.test(password); 
    const lowercaseCheck = /[a-z]/.test(password); 
    const numberCheck = /\d/.test(password); 
    const specialCheck = /[!@#$%^&*(),.?":{}|<>]/.test(password); 
    const middleCheck = /(?<=.{3})([A-Z].*\d.*[!@#$%^&*(),.?":{}|<>])|(?<=.{3})([0-9].*[A-Z].*[!@#$%^&*(),.?":{}|<>])/.test(password); 

    if (!lengthCheck) {
        return "Password must be at least 10 characters long.";
    }
    if (!uppercaseCheck || !lowercaseCheck || !numberCheck || !specialCheck) {
        return "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
    }
    if (!middleCheck) {
        return "Password must have at least one uppercase, numeric, and special character in the middle.";
    }
    return "Password is strong.";
}

// Email Validation Function
function validateEmail(email) {
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return emailRegex.test(email);
}

// Form Validation Function
function validateForm() {
    const password = document.getElementById('staff-password').value;
    const email = document.getElementById('staff-email').value;
    
    const passwordMessage = validatePassword(password);
    const emailMessage = validateEmail(email) ? "Email is valid." : "Invalid email format.";
    
    // Show the validation results
    document.getElementById('password-result').innerText = passwordMessage;
    document.getElementById('email-result').innerText = emailMessage;
    
    if (passwordMessage === "Password is strong." && emailMessage === "Email is valid.") {
        return true; // Form is valid, submit it
    } else {
        return false; // Form is not valid, prevent submission
    }
}
