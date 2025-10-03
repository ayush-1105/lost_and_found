<?php // src/includes/nav.php ?>
<nav>
    <a href="home.php">Home</a>
    <a href="create-post.php">Create Post</a>
    <a href="found.php">Found</a>
    <a href="lost.php">Lost</a>
    <a href="profile.php">Profile</a>

    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <a href="admin_home.php" style="color: #ffc107; font-weight: bold;">Admin</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php"><button>Logout</button></a>
    <?php else: ?>
        <a href="login.php"><button>Login</button></a>
    <?php endif; ?>
</nav>