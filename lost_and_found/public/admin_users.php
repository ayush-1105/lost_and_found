<?php
// public/admin_users.php
require_once '../src/includes/admin_header.php';
require_once '../src/includes/admin_nav.php';
?>
<div class="container">
    <h2>All Registered Users</h2>
    <table id="usersTable" style="width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registered On</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="5">Loading users...</td></tr>
        </tbody>
    </table>
</div>

<script src="js/admin_users.js"></script>
<?php include '../src/includes/footer.php'; ?>