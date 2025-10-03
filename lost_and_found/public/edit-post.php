<?php
// public/edit-post.php
require_once '../src/includes/auth_check.php';
include '../src/includes/header.php';
include '../src/includes/nav.php';
echo '<link rel="stylesheet" href="css/create-post.css">'; // We can reuse the same styles
?>

<div class="container">
    <h2>Edit Post</h2>
    <form id="editForm" enctype="multipart/form-data">
        <input type="hidden" id="postId" name="post_id">

        <label for="postType">Post Type</label>
        <select id="postType" name="type" required></select>

        <label for="postTitle">Title</label>
        <input type="text" id="postTitle" name="title" required>

        <label for="postLocation">Location</label>
        <input type="text" id="postLocation" name="location" required>

        <label for="postCondition">Item Condition</label>
        <input type="text" id="postCondition" name="condition" required>

        <label for="postDescription">Description</label>
        <textarea id="postDescription" name="description" required></textarea>

        <p><strong>Current Image:</strong></p>
        <img id="currentImage" src="" alt="Current Post Image" style="max-width: 200px; margin-bottom: 1rem; border-radius: 8px;">
        
        <label for="postImage">Upload New Image (Optional)</label>
        <input type="file" id="postImage" name="postImage" accept="image/*">
        
        <button type="submit">Save Changes</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editForm');
    const postIdInput = document.getElementById('postId');
    const postTypeSelect = document.getElementById('postType');
    const postTitleInput = document.getElementById('postTitle');
    const postLocationInput = document.getElementById('postLocation');
    const postConditionInput = document.getElementById('postCondition');
    const postDescriptionTextarea = document.getElementById('postDescription');
    const currentImage = document.getElementById('currentImage');

    // 1. Get the post ID from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get('id');

    if (!postId) {
        document.querySelector('.container').innerHTML = '<h2>Error: No post ID specified.</h2>';
        return;
    }

    // 2. Fetch the existing post data to populate the form
    fetch(`../src/api/get_post_details_handler.php?id=${postId}`)
        .then(response => response.json())
        .then(post => {
            if (post.error) {
                alert(post.error);
                window.location.href = 'home.php'; // Redirect if post not found or permission error
                return;
            }
            
            // Populate the form fields with the fetched data
            postIdInput.value = post.id;
            // Create options and select the correct one
            postTypeSelect.innerHTML = `
                <option value="lost" ${post.type === 'lost' ? 'selected' : ''}>I lost something</option>
                <option value="found" ${post.type === 'found' ? 'selected' : ''}>I found something</option>
            `;
            postTitleInput.value = post.title;
            postLocationInput.value = post.location;
            postConditionInput.value = post.item_condition;
            postDescriptionTextarea.value = post.description;
            currentImage.src = post.image_url || 'images/photodefault.png';
        });

    // 3. Handle the form submission to send updates
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);

        fetch('../src/api/update_post_handler.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Post updated successfully!');
                // Redirect back to the details page for the updated post
                window.location.href = `post-details.php?id=${postId}`;
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('A network error occurred.');
        });
    });
});
</script>

<?php include '../src/includes/footer.php'; ?>