<?php
// public/admin_login.php
include '../src/includes/header.php';
// You can create an admin-specific CSS file or reuse the login.css
echo '<link rel="stylesheet" href="css/login.css">';
?>
<style>
    /* A little extra style to make the admin login distinct */
    .container { border-top: 5px solid #5a2d82; }
</style>

<div class="container">
    <h2>Admin Login</h2>
    <form id="admin-login-form">
        <input type="email" id="email" placeholder="Enter your admin email" required>
        <input type="password" id="password" placeholder="Enter password" required>
        <button type="submit">Login as Admin</button>
    </form>
</div>

<script src="js/admin_login.js"></script>

<?php include '../src/includes/footer.php'; ?>