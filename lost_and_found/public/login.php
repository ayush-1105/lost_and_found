<?php // public/login.php
include '../src/includes/header.php';
echo '<link rel="stylesheet" href="css/login.css">'; // Specific CSS for this page
?>

<div class="container">
    <h2>Login</h2>
    <form id="login-form">
        <input type="email" id="email" placeholder="Enter your email" required>
        <input type="password" id="password" placeholder="Enter password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    <p><a href="forgot-password.php">Forgot Password?</a></p>
</div>

<script src="js/login.js"></script>

<?php include '../src/includes/footer.php'; ?>