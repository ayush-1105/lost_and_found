<?php
// public/profile.php
require_once '../src/includes/auth_check.php';
include '../src/includes/header.php';
include '../src/includes/nav.php';
?>
<style>
    /* Basic Profile Styles */
    .profile-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    #profileImage {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #6a11cb;
        margin-bottom: 1rem;
    }

    .profile-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .detail-box {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
    }

    .edit-field {
        display: none;
        width: 100%;
    }

    /* Key style: hide edit fields by default */
    .user-posts {
        margin-top: 3rem;
        border-top: 1px solid #eee;
        padding-top: 1.5rem;
    }

    .post-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        <img id="profileImage" src="images/avdefault.avif" alt="Profile Image">
        <h2>Your Profile</h2>
        <p><strong>Email:</strong> <span id="user-email">Loading...</span></p>
        <button id="editProfileButton">Edit Profile</button>
    </div>

    <form id="profileForm" enctype="multipart/form-data">
        <div class="profile-details">
            <div class="detail-box">
                <label>Name:</label>
                <p id="displayName" class="display-field">Loading...</p>
                <input type="text" id="editName" name="name" class="edit-field" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            <div class="detail-box">
                <label>Age:</label>
                <p id="displayAge" class="display-field">Loading...</p>
                <input type="number" id="editAge" name="age" class="edit-field" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            <div class="detail-box">
                <label>Gender:</label>
                <p id="displayGender" class="display-field">Loading...</p>
                <select id="editGender" name="gender" class="edit-field" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="detail-box">
                <label>Bio:</label>
                <p id="displayBio" class="display-field">Loading...</p>
                <input type="text" id="editBio" name="bio" class="edit-field" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div class="detail-box edit-field" style="grid-column: 1 / -1;">
                <label>Change Profile Image:</label>
                <input type="file" id="editProfileImage" name="profileImage" accept="image/*" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px; width: 100%;">
            </div>
        </div>
    </form>

    <button id="saveButton" style="display: none; margin-top: 1rem; width: 100%;">Save Changes</button>

    <div class="user-posts">
        <h3>Your Posts</h3>
        <div class="post-grid" id="userPosts">
            <p>Loading your posts...</p>
        </div>
    </div>
</div>

<script src="js/profile.js"></script>

<?php include '../src/includes/footer.php'; ?>