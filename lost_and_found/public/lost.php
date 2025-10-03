<?php
// public/lost.php
require_once '../src/includes/auth_check.php';
include '../src/includes/header.php';
// *** ADD THIS LINE to include the new stylesheet ***
echo '<link rel="stylesheet" href="css/posts.css">';
include '../src/includes/nav.php';

// The rest of your file remains the same...
$current_user_id = $_SESSION['user_id'];
$current_user_role = $_SESSION['user_role'];
?>
<div id="pageData"
     data-post-type="lost"
     data-user-id="<?php echo htmlspecialchars($current_user_id); ?>"
     data-user-role="<?php echo htmlspecialchars($current_user_role); ?>"
     style="display: none;">
</div>
<div class="container">
    <h2>Lost Items</h2>
    <div id="postsList" class="post-grid">
        <p>Loading items...</p>
    </div>
</div>
<script src="js/posts.js"></script>
<?php include '../src/includes/footer.php'; ?>