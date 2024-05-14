document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", function(event) {
        event.preventDefault();
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        const hashedPassword = CryptoJS.SHA256(password).toString();

        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', hashedPassword);

        fetch('login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = "dashboard.php";
            } else {
                alert(data.message || "Login failed. Please check your username and password.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
