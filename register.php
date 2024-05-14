<?php
// Function to hash passwords
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to send JSON response
function sendResponse($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

// Read existing users from JSON file
$users = json_decode(file_get_contents('users.json'), true);
if ($users === null) {
    $users = [];
}

// Get registration data from POST request
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Check if username and password are provided
if (empty($username) || empty($password)) {
    sendResponse(false, 'Both username and password are required.');
}

// Check if username already exists
if (isset($users[$username])) {
    sendResponse(false, 'Username already exists.');
}

// Hash the password before storing it
$hashedPassword = hashPassword($password);

// Save new user data to JSON file
$users[$username] = $hashedPassword;
if (file_put_contents('users.json', json_encode($users)) === false) {
    sendResponse(false, 'Failed to save user data.');
}

sendResponse(true, 'Registration successful.');
?>
