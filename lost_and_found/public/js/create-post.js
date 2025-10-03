// public/js/create-post.js
document.getElementById("postForm").addEventListener("submit", function(e) {
    e.preventDefault();

    // 1. Create a FormData object from the form
    const form = e.target;
    const formData = new FormData(form);

    // 2. Add the form field values manually to the FormData object
    // This gives us a chance to trim() the values
    formData.set('type', document.getElementById("postType").value);
    formData.set('title', document.getElementById("postTitle").value.trim());
    formData.set('location', document.getElementById("postLocation").value.trim());
    formData.set('condition', document.getElementById("postCondition").value.trim());
    formData.set('description', document.getElementById("postDescription").value.trim());
    
    // 3. The file input is already handled by new FormData(form), so we don't need to add it manually.

    // 4. Send the FormData object
    fetch('../src/api/create_post_handler.php', {
        method: 'POST',
        body: formData // The body is now the FormData object
        // IMPORTANT: DO NOT set the 'Content-Type' header. 
        // The browser will automatically set it to 'multipart/form-data' with the correct boundary.
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Post created successfully!');
            window.location.href = formData.get('type') === 'lost' ? 'lost.php' : 'found.php';
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('A network error occurred.');
    });
});