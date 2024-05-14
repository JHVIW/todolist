document.addEventListener("DOMContentLoaded", function() {
    const registerForm = document.getElementById("registerForm");

    registerForm.addEventListener("submit", function(event) {
        event.preventDefault();
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return;
        }

        const hashedPassword = CryptoJS.SHA256(password).toString();

        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', hashedPassword);

        fetch('register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = "index.html";
            } else {
                alert(data.message || "Registration failed. Please try again.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
