// public/js/admin_users.js
document.addEventListener('DOMContentLoaded', function() {
    const usersTableBody = document.querySelector("#usersTable tbody");
    if (!usersTableBody) return;

    fetch('../src/api/get_all_users_handler.php')
    .then(response => response.json())
    .then(users => {
        usersTableBody.innerHTML = ''; // Clear loading message
        if (users.error) {
            usersTableBody.innerHTML = `<tr><td colspan="5">${users.error}</td></tr>`;
            return;
        }
        if (users.length === 0) {
            usersTableBody.innerHTML = '<tr><td colspan="5">No users found.</td></tr>';
            return;
        }
        users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${user.role}</td>
                <td>${new Date(user.created_at).toLocaleDateString()}</td>
            `;
            usersTableBody.appendChild(row);
        });
    })
    .catch(error => {
        console.error("Error fetching users:", error);
        usersTableBody.innerHTML = '<tr><td colspan="5">Failed to load users.</td></tr>';
    });
});