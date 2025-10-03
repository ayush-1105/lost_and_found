<?php
// public/home.php

// This is the security guard for the page. It checks for a valid session.
// If the user is not logged in, it will automatically redirect them to login.php.
require_once '../src/includes/auth_check.php';

// If the script continues, the user is authenticated.
include '../src/includes/header.php';
include '../src/includes/nav.php';
?>

<style>
    .hero-section {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        text-align: center;
    }
    .hero-title { font-size: 3rem; margin-bottom: 1rem; }
    .hero-subtitle { font-size: 1.5rem; }
</style>

<section class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
        <p class="hero-subtitle">You are now logged in. You can create a post or browse lost and found items.</p>
    </div>
</section>

<?php include '../src/includes/footer.php'; ?>