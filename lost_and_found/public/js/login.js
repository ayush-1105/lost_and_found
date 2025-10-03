// public/js/login.js
document.getElementById("login-form").addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    const formData = {
        email: email,
        password: password
    };

    fetch('../src/api/login_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Login successful! Redirecting...');
            window.location.href = "home.php"; // Redirect to the main app page
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('A network error occurred. Please try again.');
    });
});