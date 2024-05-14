document.addEventListener("DOMContentLoaded", function() {
    const taskInput = document.getElementById("taskInput");
    const dateTimeInput = document.getElementById("dateTimeInput");
    const addTaskBtn = document.getElementById("addTaskBtn");
    const taskList = document.getElementById("taskList");

    // Function to fetch tasks from server
    function fetchTasks() {
        fetch('api.php')
            .then(response => response.json())
            .then(data => {
                taskList.innerHTML = '';
                if (data.success) {
                    data.data.forEach(task => {
                        const taskDateTime = new Date(task.datetime);
                        const formattedDate = taskDateTime.toLocaleDateString('nl-NL');
                        const formattedTime = taskDateTime.toLocaleTimeString('nl-NL', { hour: '2-digit', minute: '2-digit' });
                        const taskElement = document.createElement('li');
                        taskElement.textContent = `${task.task} - ${formattedDate} | ${formattedTime}`;
                        taskList.appendChild(taskElement);
                    });
                }
            });
    }

    // Add task
    addTaskBtn.addEventListener("click", function() {
        const task = taskInput.value.trim();
        const datetime = dateTimeInput.value;
        if (task !== '') {
            const formData = new FormData();
            formData.append('task', task);
            formData.append('datetime', datetime);

            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchTasks();
                    taskInput.value = '';
                    dateTimeInput.value = '';
                }
            });
        }
    });

    // Initial fetch
    fetchTasks();
});
