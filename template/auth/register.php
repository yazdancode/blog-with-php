<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
            padding: 30px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .register-header h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 8px;
        }

        .register-header p {
            color: #666;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .input-group input {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            outline: none;
            border-color: #ff6b6b;
            box-shadow: 0 0 0 2px rgba(255, 107, 107, 0.2);
        }

        .input-group input.error {
            border-color: #e74c3c;
        }

        .password-requirements {
            font-size: 12px;
            color: #777;
            margin-top: 5px;
            padding-left: 5px;
        }

        .terms {
            display: flex;
            align-items: flex-start;
            margin: 15px 0 25px;
            font-size: 14px;
        }

        .terms input {
            margin-top: 4px;
            margin-right: 10px;
        }

        .terms a {
            color: #ff6b6b;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .register-button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #ff6b6b, #ff8e8e);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .register-button:hover {
            opacity: 0.9;
        }

        .register-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .login-link a {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #ffeaea;
            border-radius: 5px;
            border: 1px solid #f5c6cb;
            font-size: 14px;
        }

        .field-error {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 5px;
            background-color: #eee;
            overflow: hidden;
        }

        .password-strength-fill {
            height: 100%;
            width: 0;
            transition: width 0.3s, background-color 0.3s;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 25px;
            }

            .input-group input {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
<div class="register-container">
    <div class="register-header">
        <h1>Create Account</h1>
        <p>Join us today and get started</p>
    </div>

    <?php
    $showError = false;
    $errorMessage = "Registration failed. Please try again.";

    if (isset($_GET['error'])) {
        $showError = true;

        // پیام‌های خطای مختلف بر اساس کد خطا
        switch ($_GET['error']) {
            case '1':
                $errorMessage = "Email already exists. Please use a different email.";
                break;
            case '2':
                $errorMessage = "Passwords do not match.";
                break;
            case '3':
                $errorMessage = "Password does not meet requirements.";
                break;
            default:
                $errorMessage = "Registration failed. Please try again.";
        }
    }
    ?>

    <form id="registerForm" action="http://localhost/project/register/store" method="POST">
        <?php if ($showError): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <div class="input-group">
            <label for="username">Full Name</label>
            <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter your full name"
                    required
            >
            <div class="field-error" id="username-error">Please enter your full name</div>
        </div>

        <div class="input-group">
            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
            >
            <div class="field-error" id="email-error">Please enter a valid email address</div>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Create a password"
                required
            >
            <div class="password-strength">
                <div class="password-strength-fill" id="password-strength-fill"></div>
            </div>
            <div class="password-requirements">
                Must be at least 8 characters with uppercase, lowercase, and number
            </div>
            <div class="field-error" id="password-error">Password must be at least 8 characters with uppercase, lowercase, and number</div>
        </div>

        <div class="input-group">
            <label for="confirm-password">Confirm Password</label>
            <input
                type="password"
                id="confirm-password"
                name="confirm-password"
                placeholder="Confirm your password"
                required
            >
            <div class="field-error" id="confirm-password-error">Passwords do not match</div>
        </div>

        <div class="terms">
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">
                I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
            </label>
        </div>
        <div class="field-error" id="terms-error">You must agree to the terms and conditions</div>

        <button type="submit" class="register-button" id="submit-button">Create Account</button>
    </form>

    <div class="login-link">
        <p>Already have an account? <a href="login.php">Sign in</a></p>
    </div>
</div>

<script>
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
</script>
</body>
</html>