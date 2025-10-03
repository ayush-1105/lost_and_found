<?php
// public/admin_found.php
require_once '../src/includes/admin_header.php';
require_once '../src/includes/admin_nav.php';
echo '<link rel="stylesheet" href="css/posts.css">';

$current_user_id = $_SESSION['user_id'];
$current_user_role = $_SESSION['user_role'];
?>

<div id="pageData"
     data-post-type="found"
     data-user-id="<?php echo htmlspecialchars($current_user_id); ?>"
     data-user-role="<?php echo htmlspecialchars($current_user_role); ?>"
     style="display: none;">
</div>

<div class="container">
    <h2>All Found Posts (Admin View)</h2>
    <div id="postsList" class="post-grid">
        <p>Loading items...</p>
    </div>
</div>

<script src="js/posts.js"></script>

<?php include '../src/includes/footer.php'; ?>