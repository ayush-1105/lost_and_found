<?php
// public/create-post.php

// Step 1: Secure the page. Only logged-in users can access this.
require_once '../src/includes/auth_check.php';

// Step 2: Include the standard HTML header and session start.
include '../src/includes/header.php';

// Step 3: Include the main navigation bar.
include '../src/includes/nav.php';

// Step 4: Link to the specific stylesheet for this page's form.
echo '<link rel="stylesheet" href="css/create-post.css">';
?>

<div class="container">
    <h2>Create a Post</h2>
    
    <form id="postForm" enctype="multipart/form-data">

        <label for="postType">What is the nature of your post?</label>
        <select id="postType" name="type" required>
            <option value="lost">I lost something</option>
            <option value="found">I found something</option>
        </select>

        <label for="postTitle">Title</label>
        <input type="text" id="postTitle" name="title" placeholder="e.g., Black Leather Wallet" required>

        <label for="postLocation">Last Known Location</label>
        <input type="text" id="postLocation" name="location" placeholder="e.g., Near FC College, Pune" required>

        <label for="postCondition">Item Condition</label>
        <input type="text" id="postCondition" name="condition" placeholder="e.g., Slightly worn, good condition" required>

        <label for="postDescription">Description</label>
        <textarea id="postDescription" name="description" placeholder="Describe a special feature or identifying mark that only the owner would know." required></textarea>

        <label for="postImage">Upload Image (Optional):</label>
        <input type="file" id="postImage" name="postImage" accept="image/png, image/jpeg, image/gif">
        
        <button type="submit">Create Post</button>
    </form>
</div>

<script src="js/create-post.js"></script>

<?php
// Step 7: Include the standard HTML footer.
include '../src/includes/footer.php';
?>