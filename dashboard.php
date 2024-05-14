<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List with DateTime Selector</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="container">
        <h1>To-Do List</h1>
        <div class="input-container">
            <input type="text" id="taskInput" placeholder="Add a task...">
            <input type="datetime-local" id="dateTimeInput">
            <button id="addTaskBtn">Add Task</button>
        </div>
        <ul id="taskList"></ul>
        <a href="logout.php">Logout</a>
    </div>
    <script src="script.js"></script>
</body>
</html>
