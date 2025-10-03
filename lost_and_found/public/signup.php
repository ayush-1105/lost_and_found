<?php

$pageTitle = "Sign Up";
include '../src/includes/header.php';

echo '<link rel="stylesheet" href="css/signup.css">';
?>

<div class="container">
    <h2>Sign Up</h2>
    <form id="signup-form">
        <input type="text" id="name" placeholder="Full Name" required />
        <input type="number" id="age" placeholder="Age" required />
        <select id="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        <input type="email" id="email" placeholder="Enter your email" required />
        <input type="password" id="password" placeholder="Enter password" required />
        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

<script src="js/signup.js"></script>
<?php include '../src/includes/footer.php'; ?>