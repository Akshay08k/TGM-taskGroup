<?php
include 'connection.php';

// Fetch workgroups
$workgroupsResult = $conn->query("SELECT id, name FROM workgroups");

// Store Task on Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $workgroup_id = $_POST['workgroup'];
    $task_name = $_POST['task_name'];
    $task_desc = $_POST['task_desc'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $user_id = $_POST['assigned_user']; // User ID selected for task assignment

    // Insert task into tasks table
    $sql = "INSERT INTO tasks (workgroup, assigned_to, task_name, task_desc, due_date, priority) 
            VALUES ('$workgroup_id', '$user_id', '$task_name', '$task_desc', '$due_date', '$priority')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Task assigned successfully!'); window.location.href='assign_task.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Task | Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="bg-gray-100">

    <nav class="bg-blue-600 p-4 flex justify-between items-center">
        <div class="text-white text-xl font-bold">TGM - Task Group Management</div>
    </nav>

    <div class="flex">
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

        <main class="flex-1 p-10">
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-8">Assign a Task</h1>
                <form id="assign-task-form" class="space-y-6" method="post" action="">
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Workgroup Selection -->
                        <div>
                            <label for="workgroup" class="block text-gray-600 font-medium mb-2">Select Workgroup</label>
                            <select id="workgroup" name="workgroup"
                                class="w-full border border-gray-300 rounded-md p-3 focus:ring focus:ring-blue-500"
                                required>
                                <option value="">Select Workgroup</option>
                                <?php
                                // Fetch and display workgroups from the database
                                while ($row = $workgroupsResult->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Task Name -->
                        <div>
                            <label for="task-name" class="block text-gray-600 font-medium mb-2">Task Name</label>
                            <input type="text" id="task-name" name="task_name" placeholder="Enter task name"
                                class="w-full border border-gray-300 rounded-md p-3 focus:ring focus:ring-blue-500"
                                required>
                        </div>
                    </div>

                    <!-- Task Description -->
                    <div>
                        <label for="task-desc" class="block text-gray-600 font-medium mb-2">Task Description</label>
                        <textarea id="task-desc" name="task_desc" rows="5"
                            class="w-full border border-gray-300 rounded-md p-3 focus:ring focus:ring-blue-500"
                            placeholder="Enter task description" required></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Due Date -->
                        <div>
                            <label for="due-date" class="block text-gray-600 font-medium mb-2">Due Date</label>
                            <input type="date" id="due-date" name="due_date"
                                class="w-full border border-gray-300 rounded-md p-3 focus:ring focus:ring-blue-500"
                                required>
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block text-gray-600 font-medium mb-2">Priority</label>
                            <select id="priority" name="priority"
                                class="w-full border border-gray-300 rounded-md p-3 focus:ring focus:ring-blue-500">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                    </div>

                    <!-- User Selection -->
                    <div>
                        <label for="assigned-user" class="block text-gray-600 font-medium mb-2">Assign to User</label>
                        <select id="assigned-user" name="assigned_user"
                            class="w-full border border-gray-300 rounded-md p-3 focus:ring focus:ring-blue-500"
                            required>
                            <!-- Users will be dynamically loaded here via AJAX -->
                        </select>
                    </div>

                    <!-- Assign Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-200">Assign
                            Task</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Fetch users based on the selected workgroup using AJAX
        $('#workgroup').change(function () {
            var workgroupId = $(this).val();
            if (workgroupId) {
                $.ajax({
                    type: 'POST',
                    url: 'fetch_users.php',
                    data: { workgroup_id: workgroupId },
                    success: function (response) {
                        $('#assigned-user').html(response);
                    }
                });
            } else {
                $('#assigned-user').html('<option value="">Select Workgroup First</option>');
            }
        });
    </script>
</body>

</html>