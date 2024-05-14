<?php
session_start();

// Function to verify hashed passwords
function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
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

// Get login data from POST request
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Check if username and password are provided
if (empty($username) || empty($password)) {
    sendResponse(false, 'Please provide both username and password.');
}

// Check if username exists
if (!isset($users[$username])) {
    sendResponse(false, 'Invalid username or password.');
}

// Verify password
if (!verifyPassword($password, $users[$username])) {
    sendResponse(false, 'Invalid username or password.');
}

// Login successful
$_SESSION['loggedin'] = true;
$_SESSION['username'] = $username;
sendResponse(true, 'Login successful.');
?>
