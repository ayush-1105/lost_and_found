// public/js/admin_login.js
document.getElementById("admin-login-form").addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    const formData = {
        email: email,
        password: password
    };

    fetch('../src/api/admin_login_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Admin login successful! Redirecting to the admin dashboard...');
            // On success, redirect to the main admin home page.
            window.location.href = "admin_home.php";
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('A network error occurred. Please try again.');
    });
});