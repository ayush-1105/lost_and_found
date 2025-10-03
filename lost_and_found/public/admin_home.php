<?php
// public/admin_home.php
require_once '../src/includes/admin_header.php'; // Use the new admin header
require_once '../src/includes/admin_nav.php';   // Use the new admin nav
?>
<style>
    .dashboard-container { text-align: center; padding: 4rem 2rem; }
    .dashboard-container h1 { font-size: 3rem; color: #333; }
    .dashboard-container p { font-size: 1.2rem; color: #555; }
</style>
<div class="dashboard-container">
    <h1>Welcome, Admin!</h1>
    <p>Select an option from the navigation bar to manage users and posts.</p>
</div>
<?php include '../src/includes/footer.php'; ?>