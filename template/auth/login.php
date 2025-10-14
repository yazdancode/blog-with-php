<?php
require_once __DIR__ . '/../../helpers/UrlHelper.php';
use helpers\UrlHelper;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo UrlHelper::assetsUrl('css/auth/login.css'); ?>">
</head>
<body>
<div class="login-container">
    <div class="login-header">
        <h1>Welcome Back</h1>
        <p>Please sign in to your account</p>
    </div>

    <?php
    $showError = false;
    if (isset($_GET['error']) && $_GET['error'] === 1) {
        $showError = true;
    }
    $httpReferer = $_SERVER['HTTP_REFERER'] ?? null;
    ?>

    <form action="http://localhost/project/check-login" method="POST">
        <?php if ($showError): ?>
            <div class="error-message">
                Invalid email or password. Please try again.
            </div>
        <?php endif; ?>

        <div class="input-group">
            <label for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
                autocomplete="email"
            >
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
                autocomplete="current-password"
            >
        </div>

        <div class="options">
            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>
            <a href="#" class="forgot-password">Forgot Password?</a>
        </div>

        <button type="submit" class="login-button">Sign In</button>
    </form>

    <div class="signup-link">
        <p>Don't have an account? <a href="#">Sign up</a></p>
    </div>
</div>

<!-- SweetAlert Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Conditional Error Alert -->
<script src="<?php echo UrlHelper::assetsUrl("js/auth/login.js")?>"></script>
</body>
</html>