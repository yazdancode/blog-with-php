
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const passwordStrengthFill = document.getElementById('password-strength-fill');
    const submitButton = document.getElementById('submit-button');

    // اعتبارسنجی پسورد در حین تایپ
    passwordInput.addEventListener('input', function() {
    validatePassword();
    checkPasswordsMatch();
    updateSubmitButton();
});

    // اعتبارسنجی تطابق پسوردها
    confirmPasswordInput.addEventListener('input', function() {
    checkPasswordsMatch();
    updateSubmitButton();
});

    // اعتبارسنجی فرم قبل از ارسال
    form.addEventListener('submit', function(e) {
    if (!validateForm()) {
    e.preventDefault();
}
});

    // اعتبارسنجی پسورد
    function validatePassword() {
    const password = passwordInput.value;
    const errorElement = document.getElementById('password-error');
    let isValid = true;

    // بررسی طول پسورد
    if (password.length < 8) {
    isValid = false;
}

    // بررسی وجود حروف بزرگ
    if (!/(?=.*[A-Z])/.test(password)) {
    isValid = false;
}

    // بررسی وجود حروف کوچک
    if (!/(?=.*[a-z])/.test(password)) {
    isValid = false;
}

    // بررسی وجود عدد
    if (!/(?=.*\d)/.test(password)) {
    isValid = false;
}

    // نمایش خطا و به‌روزرسانی استایل
    if (!isValid && password.length > 0) {
    errorElement.style.display = 'block';
    passwordInput.classList.add('error');
} else {
    errorElement.style.display = 'none';
    passwordInput.classList.remove('error');
}

    // به‌روزرسانی نشانگر قدرت پسورد
    updatePasswordStrength(password);

    return isValid;
}

    // بررسی تطابق پسوردها
    function checkPasswordsMatch() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    const errorElement = document.getElementById('confirm-password-error');

    if (confirmPassword.length > 0 && password !== confirmPassword) {
    errorElement.style.display = 'block';
    confirmPasswordInput.classList.add('error');
    return false;
} else {
    errorElement.style.display = 'none';
    confirmPasswordInput.classList.remove('error');
    return true;
}
}

    // به‌روزرسانی نشانگر قدرت پسورد
    function updatePasswordStrength(password) {
    let strength = 0;

    if (password.length >= 8) strength += 25;
    if (/(?=.*[a-z])/.test(password)) strength += 25;
    if (/(?=.*[A-Z])/.test(password)) strength += 25;
    if (/(?=.*\d)/.test(password)) strength += 25;

    passwordStrengthFill.style.width = strength + '%';

    // تغییر رنگ بر اساس قدرت
    if (strength < 50) {
    passwordStrengthFill.style.backgroundColor = '#e74c3c';
} else if (strength < 75) {
    passwordStrengthFill.style.backgroundColor = '#f39c12';
} else {
    passwordStrengthFill.style.backgroundColor = '#2ecc71';
}
}

    // اعتبارسنجی کامل فرم
    function validateForm() {
    const isPasswordValid = validatePassword();
    const isPasswordMatch = checkPasswordsMatch();
    const isTermsChecked = document.getElementById('terms').checked;

    if (!isTermsChecked) {
    document.getElementById('terms-error').style.display = 'block';
} else {
    document.getElementById('terms-error').style.display = 'none';
}

    return isPasswordValid && isPasswordMatch && isTermsChecked;
}

    // به‌روزرسانی وضعیت دکمه ارسال
    function updateSubmitButton() {
    const isPasswordValid = validatePassword();
    const isPasswordMatch = checkPasswordsMatch();

    if (isPasswordValid && isPasswordMatch) {
    submitButton.disabled = false;
} else {
    submitButton.disabled = true;
}
}
});