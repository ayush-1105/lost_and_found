// public/js/profile.js
document.addEventListener('DOMContentLoaded', function() {
    const editButton = document.getElementById('editProfileButton');
    const saveButton = document.getElementById('saveButton');
    const displayElements = document.querySelectorAll('.display-field');
    const editElements = document.querySelectorAll('.edit-field');
    const userPostsContainer = document.getElementById('userPosts');

    function loadProfile() {
        fetch('../src/api/get_profile_handler.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error); return;
                }
                
                const user = data.userDetails;
                document.getElementById('profileImage').src = user.profile_image_url || 'images/avdefault.avif';
                document.getElementById('user-email').textContent = user.email;
                
                document.getElementById('displayName').textContent = user.name;
                document.getElementById('editName').value = user.name;

                document.getElementById('displayAge').textContent = user.age;
                document.getElementById('editAge').value = user.age;

                document.getElementById('displayGender').textContent = user.gender;
                // *** FIX for Gender Selection ***
                // This line sets the dropdown to the correct value from the database.
                document.getElementById('editGender').value = user.gender;
                
                document.getElementById('displayBio').textContent = user.bio || 'Not set';
                document.getElementById('editBio').value = user.bio || '';
                
                userPostsContainer.innerHTML = '';
                if (data.userPosts.length > 0) {
                    data.userPosts.forEach(post => {
                        const postElement = document.createElement('div');
                        postElement.className = 'post-card';
                        postElement.innerHTML = `<h4>${post.title}</h4><p>Type: ${post.type}</p><small>${new Date(post.created_at).toLocaleDateString()}</small>`;
                        postElement.onclick = () => window.location.href = `post-details.php?id=${post.id}`;
                        userPostsContainer.appendChild(postElement);
                    });
                } else {
                    userPostsContainer.innerHTML = '<p>You have not created any posts yet.</p>';
                }
            })
            .catch(error => console.error("Error loading profile:", error));
    }

    editButton.addEventListener('click', () => {
        displayElements.forEach(el => el.style.display = 'none');
        editElements.forEach(el => el.style.display = 'block');
        saveButton.style.display = 'block';
        editButton.style.display = 'none';
    });

    saveButton.addEventListener('click', () => {
        // *** FIX for Image Upload ***
        // We now use a FormData object to send the form data, including the file.
        const form = document.getElementById('profileForm');
        const formData = new FormData(form);

        // Manually set text values to ensure they are included
        formData.set('name', document.getElementById('editName').value);
        formData.set('age', document.getElementById('editAge').value);
        formData.set('gender', document.getElementById('editGender').value);
        formData.set('bio', document.getElementById('editBio').value);

        fetch('../src/api/update_profile_handler.php', {
            method: 'POST',
            body: formData // Send the FormData object
            // No 'Content-Type' header needed; the browser sets it automatically
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Profile updated successfully!');
                location.reload(); 
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => console.error("Error updating profile:", error));
    });

    loadProfile();
});