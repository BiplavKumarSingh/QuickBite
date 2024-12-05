function checkPasswordStrength() {
    const password = document.getElementById("password").value;
    const strengthDiv = document.getElementById("password-strength");
    const regexWeak = /.{0,7}/; // Less than 8 characters
    const regexMedium = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/; // Must contain at least one letter and one number
    const regexStrong = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/; // Must contain special characters, letters, and numbers

    if (regexStrong.test(password)) {
        strengthDiv.innerHTML = "Strong password.";
        strengthDiv.classList.add("strong");
        strengthDiv.classList.remove("weak", "medium");
    } else if (regexMedium.test(password)) {
        strengthDiv.innerHTML = "Medium password.";
        strengthDiv.classList.add("medium");
        strengthDiv.classList.remove("weak", "strong");
    } else if (regexWeak.test(password)) {
        strengthDiv.innerHTML = "Weak password (must be at least 8 characters).";
        strengthDiv.classList.add("weak");
        strengthDiv.classList.remove("medium", "strong");
    }
}