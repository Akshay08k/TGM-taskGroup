<?php
include 'connection.php';
// Fetch workgroups and their tasks
$workgroupsResult = $conn->query("SELECT * FROM workgroups");
$workgroups = [];

while ($workgroup = $workgroupsResult->fetch_assoc()) {
    $workgroup_id = $workgroup['id'];
    // Join tasks with users to get user names
    $tasksResult = $conn->query("SELECT tasks.*, users.name AS assigned_name 
                                  FROM tasks 
                                  JOIN users ON tasks.assigned_to = users.id 
                                  WHERE tasks.workgroup = '$workgroup_id'");
    $tasks = [];

    while ($task = $tasksResult->fetch_assoc()) {
        $tasks[] = $task;
    }

    $workgroups[] = [
        'workgroup' => $workgroup,
        'tasks' => $tasks
    ];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Workgroup Tasks | Team Leader Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <nav class="bg-blue-600 p-4 flex justify-between items-center">
        <div class="text-white text-xl font-bold">TGM - Task Group Management</div>
        <div class="text-white">
            Welcome, <span id="username" class="font-semibold">Team Leader</span>
        </div>
    </nav>

    <div class="min-h-screen flex">
        <aside class="sidebar w-64 h-screen bg-gradient-to-br from-blue-800 to-blue-600 text-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">TGM Dashboard</h2>
                <ul>
                    <li class="mb-4">
                        <a href="team_leader_dashboard.php"
                            class="flex items-center space-x-4 p-3 hover:bg-blue-700 rounded-lg transition duration-200">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="create_workgroup.php"
                            class="flex items-center space-x-4 p-3 hover:bg-blue-700 rounded-lg transition duration-200">
                            <i class="fas fa-users"></i>
                            <span>Create Workgroup</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="assign_task.php"
                            class="flex items-center space-x-4 p-3 hover:bg-blue-700 rounded-lg transition duration-200">
                            <i class="fas fa-tasks"></i>
                            <span>Assign Tasks</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="view_tasks.php"
                            class="flex items-center space-x-4 p-3 hover:bg-blue-700 rounded-lg transition duration-200">
                            <i class="fas fa-eye"></i>
                            <span>View Tasks</span>
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="view_members.php"
                            class="flex items-center space-x-4 p-3 hover:bg-blue-700 rounded-lg transition duration-200">
                            <i class="fas fa-user-friends"></i>
                            <span>View Users</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <nav class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg mb-8">
                <div>
                    <h1 class="text-xl font-semibold text-gray-700">View Workgroup Tasks</h1>
                </div>
            </nav>

            <section>
                <?php foreach ($workgroups as $workgroupData): ?>
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Workgroup:
                            <strong><?php echo htmlspecialchars($workgroupData['workgroup']['name']); ?></strong>
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php if (empty($workgroupData['tasks'])): ?>
                                <p class="text-gray-600">No tasks available for this workgroup.</p>
                            <?php else: ?>
                                <?php foreach ($workgroupData['tasks'] as $task): ?>
                                    <div class="bg-white p-6 rounded-lg shadow-md relative">
                                        <span
                                            class="absolute top-4 right-4 <?php echo ($task['priority'] == 'high' ? 'bg-red-500' : ($task['priority'] == 'medium' ? 'bg-yellow-500' : 'bg-green-500')); ?> text-white px-3 py-1 rounded-full text-xs"><?php echo ucfirst($task['priority']); ?></span>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                            <?php echo htmlspecialchars($task['task_name']); ?>
                                        </h3>
                                        <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($task['task_desc']); ?></p>
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="text-sm text-gray-500">Assigned to:
                                                    <strong><?php echo htmlspecialchars($task['assigned_name']); ?></strong>
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">Due Date:
                                                    <strong><?php echo htmlspecialchars($task['due_date']); ?></strong>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-4 flex space-x-2">
                                            <button
                                                onclick="openUpdateModal(<?php echo $task['id']; ?>, '<?php echo htmlspecialchars($task['task_name']); ?>', '<?php echo htmlspecialchars($task['task_desc']); ?>', '<?php echo htmlspecialchars($task['due_date']); ?>')"
                                                class="bg-yellow-400 hover:bg-yellow-500 text-white py-2 px-4 rounded-md transition duration-200">
                                                <i class="fas fa-edit"></i> Update
                                            </button>
                                            <button onclick="openDeleteModal(<?php echo $task['id']; ?>)"
                                                class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md transition duration-200">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

            <!-- Update Task Modal -->
            <div id="updateTaskModal"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
                    <h2 class="text-lg font-semibold mb-4">Update Task</h2>
                    <form id="updateTaskForm">
                        <input type="hidden" name="task_id" id="updateTaskId">
                        <div>
                            <label for="updateTaskName" class="block text-gray-600 font-medium">Task Name</label>
                            <input type="text" id="updateTaskName" name="task_name"
                                class="w-full border border-gray-300 rounded-md p-2" required>
                        </div>
                        <div>
                            <label for="updateTaskDesc" class="block text-gray-600 font-medium">Task Description</label>
                            <textarea id="updateTaskDesc" name="task_desc"
                                class="w-full border border-gray-300 rounded-md p-2" required></textarea>
                        </div>
                        <div>
                            <label for="updateDueDate" class="block text-gray-600 font-medium">Due Date</label>
                            <input type="date" id="updateDueDate" name="due_date"
                                class="w-full border border-gray-300 rounded-md p-2" required>
                        </div>
                        <button type="submit"
                            class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 mt-4">Update
                            Task</button>
                        <button type="button" onclick="closeModal('updateTaskModal')"
                            class="text-red-500 mt-4">Cancel</button>
                    </form>
                </div>
            </div>

            <!-- Delete Task Modal -->
            <div id="deleteTaskModal"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
                    <h2 class="text-lg font-semibold mb-4">Delete Task</h2>
                    <p>Are you sure you want to delete this task?</p>
                    <input type="hidden" name="task_id" id="deleteTaskId">
                    <button id="confirmDeleteButton"
                        class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 mt-4">Delete</button>
                    <button type="button" onclick="closeModal('deleteTaskModal')"
                        class="text-gray-500 mt-4">Cancel</button>
                </div>
            </div>

        </main>
    </div>
    <script>
        function openUpdateModal(taskId, taskName, taskDesc, dueDate) {
            document.getElementById('updateTaskId').value = taskId;
            document.getElementById('updateTaskName').value = taskName;
            document.getElementById('updateTaskDesc').value = taskDesc;
            document.getElementById('updateDueDate').value = dueDate;
            document.getElementById('updateTaskModal').classList.remove('hidden');
        }

        function openDeleteModal(taskId) {
            document.getElementById('deleteTaskId').value = taskId;
            document.getElementById('deleteTaskModal').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Handle Update Task Form Submission
        document.getElementById('updateTaskForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const taskId = document.getElementById('updateTaskId').value;
            const taskName = document.getElementById('updateTaskName').value;
            const taskDesc = document.getElementById('updateTaskDesc').value;
            const dueDate = document.getElementById('updateDueDate').value;

            // Make an AJAX request to update the task
            fetch('update_task.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: taskId, task_name: taskName, task_desc: taskDesc, due_date: dueDate })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Task updated successfully!');
                        location.reload();
                    } else {
                        alert('Error updating task: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Handle Delete Task
        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            const taskId = document.getElementById('deleteTaskId').value;

            fetch('delete_task.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: taskId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Task deleted successfully!');
                        location.reload();
                    } else {
                        alert('Error deleting task: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>