// public/js/signup.js
document.getElementById("signup-form").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = {
        name: document.getElementById("name").value.trim(),
        age: document.getElementById("age").value.trim(),
        gender: document.getElementById("gender").value,
        email: document.getElementById("email").value.trim(),
        password: document.getElementById("password").value.trim()
    };

   

    fetch('../src/api/signup_handler.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            
            alert('Signup successful! Redirecting to login...');
            window.location.href = "login.php";
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('A network error occurred.');
    });
});