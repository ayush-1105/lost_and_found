// public/js/posts.js
document.addEventListener('DOMContentLoaded', function() {
    // Read user and page data from our hidden div.
    const pageDataElement = document.getElementById('pageData');
    if (!pageDataElement) return;

    const postType = pageDataElement.dataset.postType;
    const currentUserId = parseInt(pageDataElement.dataset.userId, 10);
    const userIsAdmin = pageDataElement.dataset.userRole === 'admin';
    const postsList = document.getElementById('postsList');

    // --- Main function to fetch and display all posts ---
    function fetchAndRenderPosts() {
        fetch(`../src/api/get_posts_handler.php?type=${postType}`)
        .then(response => response.json())
        .then(posts => {
            postsList.innerHTML = '';
            if (posts.length === 0) {
                postsList.innerHTML = `<p class="no-posts">No ${postType} items have been posted yet.</p>`;
                return;
            }

            posts.forEach(post => {
                const isOwner = post.user_id == currentUserId;
                const postElement = document.createElement('div');
                postElement.className = `post-card ${post.status === 'done' ? 'done' : ''}`;
                
                const imageUrl = post.image_url || 'images/photodefault.png';
                const avatarUrl = post.author_avatar || 'images/avdefault.avif';

                // --- LOGIC FOR ACTION BUTTONS ---
                let actionButtons = '';
                if (post.status !== 'done') {
                    if (isOwner) {
                        // For the owner of an open post
                        actionButtons += `<button class="edit-btn" data-id="${post.id}">Edit</button>`;
                        actionButtons += `<button class="done-btn" data-id="${post.id}">Mark as Done</button>`;
                    }
                }
                if (isOwner || userIsAdmin) {
                     actionButtons += `<button class="delete-btn" data-id="${post.id}">Delete</button>`;
                }
                
                // If the post is done, add a visual indicator
                let statusIndicator = '';
                if (post.status === 'done') {
                    statusIndicator = '<div class="status-badge">Completed</div>';
                }

                postElement.innerHTML = `
                    ${statusIndicator}
                    <a href="post-details.php?id=${post.id}" class="post-link">
                        <div class="post-image-container">
                            <img class="post-image" src="${imageUrl}" alt="${post.title}" onerror="this.src='images/photodefault.png'">
                        </div>
                        <div class="post-content">
                            <div class="user-info">
                                <img class="user-avatar" src="${avatarUrl}" alt="${post.author_name}'s avatar" onerror="this.src='images/avdefault.avif'">
                                <div><h3>${post.author_name}</h3><small>${new Date(post.created_at).toLocaleDateString()}</small></div>
                            </div>
                            <h4>${post.title}</h4>
                            <p><strong>Location:</strong> ${post.location}</p>
                        </div>
                    </a>
                    <div class="post-actions">${actionButtons}</div>
                `;
                postsList.appendChild(postElement);
            });
        })
        .catch(error => console.error('Fetch Error:', error));
    }

    // --- Event listener to handle all button clicks ---
    postsList.addEventListener('click', function(e) {
        const target = e.target;
        const postId = target.dataset.id;

        if (target.matches('.done-btn')) {
            if (confirm('Are you sure you want to mark this item as completed?')) {
                updatePostStatus(postId);
            }
        } else if (target.matches('.delete-btn')) {
            if (confirm('Are you sure you want to permanently delete this post?')) {
                deletePost(postId);
            }
        } else if (target.matches('.edit-btn')) {
            // Redirect to a future edit page
            window.location.href = `edit-post.php?id=${postId}`;
        }
    });

    // --- Functions to call our new APIs ---
    function updatePostStatus(postId) {
        fetch('../src/api/update_post_status_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ post_id: postId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Post updated!');
                fetchAndRenderPosts(); // Refresh the list to show the change
            } else {
                alert('Error: ' + data.error);
            }
        });
    }

    function deletePost(postId) {
        fetch('../src/api/delete_post_handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ post_id: postId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Post deleted!');
                fetchAndRenderPosts(); // Refresh the list
            } else {
                alert('Error: ' + data.error);
            }
        });
    }

    // --- Initial page load ---
    fetchAndRenderPosts();
});