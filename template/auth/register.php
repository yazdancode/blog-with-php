<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../../public/css/auth/register.css">
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

<script src="../../public/js/auth/register.js"></script>
</body>
</html>