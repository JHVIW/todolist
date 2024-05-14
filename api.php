<?php
session_start();

// Function to send JSON response
function sendResponse($success, $data = null, $message = '') {
    echo json_encode(['success' => $success, 'data' => $data, 'message' => $message]);
    exit;
}

// Read existing tasks from JSON file
$tasks = json_decode(file_get_contents('tasks.json'), true);
if ($tasks === null) {
    $tasks = ['users' => []];
}

// Get the logged in user's username
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Return the tasks for the logged in user
    if (isset($tasks['users'][$username])) {
        sendResponse(true, $tasks['users'][$username]['tasks']);
    } else {
        sendResponse(true, []);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST['task'];
    $datetime = $_POST['datetime'];

    if (!isset($tasks['users'][$username])) {
        $tasks['users'][$username] = ['tasks' => []];
    }

    $tasks['users'][$username]['tasks'][] = [
        "task" => $task,
        "datetime" => $datetime
    ];

    file_put_contents('tasks.json', json_encode($tasks));
    sendResponse(true, $tasks['users'][$username]['tasks']);
}
?>
