<?php
// public/post-details.php
require_once '../src/includes/auth_check.php';
include '../src/includes/header.php';
include '../src/includes/nav.php';
?>

<style>
    /* Some basic styling for the details page */
    .post-details-container { max-width: 900px; margin: 2rem auto; padding: 2rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .post-image { width: 100%; max-height: 500px; object-fit: cover; border-radius: 8px; margin-bottom: 1.5rem; }
    .post-meta { color: #555; margin-bottom: 1rem; }
    .post-description { line-height: 1.7; white-space: pre-wrap; }
</style>

<div class="post-details-container">
    <img id="postImage" src="images/photodefault.png" alt="Post Image" class="post-image" onerror="this.src='images/photodefault.png'">
    <h2 id="postTitle">Loading...</h2>
    <div class="post-meta">
        Posted by <strong id="authorName">...</strong> on <span id="postDate">...</span>
    </div>
    <p><strong>📍 Location:</strong> <span id="postLocation">...</span></p>
    <p><strong>🔄 Condition:</strong> <span id="itemCondition">...</span></p>
    <hr>
    <h3>Description</h3>
    <p id="postDescription" class="post-description">...</p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Get the post ID from the page's URL
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get('id');

    if (!postId) {
        document.querySelector('.post-details-container').innerHTML = '<h2>Error: No post ID specified.</h2>';
        return;
    }

    // 2. Fetch the data for this specific post from our API
    fetch(`../src/api/get_post_details_handler.php?id=${postId}`)
        .then(response => response.json())
        .then(post => {
            if (post.error) {
                document.querySelector('.post-details-container').innerHTML = `<h2>Error: ${post.error}</h2>`;
                return;
            }

            // 3. Populate the HTML elements with the fetched data
            document.getElementById('postImage').src = post.image_url || 'images/photodefault.png';
            document.getElementById('postTitle').textContent = post.title;
            document.getElementById('authorName').textContent = post.author_name;
            document.getElementById('postDate').textContent = new Date(post.created_at).toLocaleDateString();
            document.getElementById('postLocation').textContent = post.location;
            document.getElementById('itemCondition').textContent = post.item_condition;
            document.getElementById('postDescription').textContent = post.description;
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            document.querySelector('.post-details-container').innerHTML = '<h2>Error loading post data.</h2>';
        });
});
</script>

<?php include '../src/includes/footer.php'; ?>