<?php
session_start();
require 'connection.php'; // Include database connection

// Fetch current user ID (from session)
$user_id = $_SESSION['user_id']; // Adjust according to your session setup

// Fetch tasks assigned to the user in their workgroups
$query = "SELECT t.*, w.name AS workgroup_name, u.name AS assigned_by_name 
          FROM tasks t
          INNER JOIN workgroups w ON t.workgroup = w.id
          INNER JOIN users u ON t.assigned_by = u.id
          WHERE t.assigned_to = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tasks</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="bg-blue-600 text-white w-64 p-5 flex flex-col">
            <h1 class="text-2xl font-bold mb-6">TGM</h1>
            <ul class="space-y-4 flex-grow">
                <li>
                    <a href="team_member_dashboard.php" class="block p-3 rounded hover:bg-blue-700 transition">Join
                        Workgroups</a>
                </li>
                <li>
                    <a href="view_tasks_member.php" class="block p-3 rounded hover:bg-blue-700 transition">View
                        Tasks</a>
                </li>
                <li>
                    <a href="logout.php" class="block p-3 rounded hover:bg-blue-700 transition">Logout</a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-5 overflow-y-auto">
            <h2 class="text-2xl font-semibold">Your Tasks</h2>

            <!-- Task Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                <?php if (!empty($tasks)): ?>
                    <?php foreach ($tasks as $task): ?>
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($task['task_name']); ?></h3>
                            <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($task['task_desc']); ?></p>
                            <p class="text-gray-500 mb-2"><strong>Due Date:</strong>
                                <?php echo htmlspecialchars($task['due_date']); ?></p>
                            <p class="text-gray-500 mb-2"><strong>Priority:</strong>
                                <?php echo htmlspecialchars($task['priority']); ?></p>
                            <p class="text-gray-500 mb-2"><strong>Workgroup:</strong>
                                <?php echo htmlspecialchars($task['workgroup_name']); ?></p>
                            <p class="text-gray-500 mb-2"><strong>Assigned By:</strong>
                                <?php echo htmlspecialchars($task['assigned_by_name']); ?></p>
                            <p class="text-gray-500 mb-4"><strong>Status:</strong>
                                <?php echo htmlspecialchars($task['status']); ?></p>

                            <!-- Task status update form -->
                            <form action="update_task_status.php" method="POST">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                <label for="status" class="block mb-2 text-gray-700">Update Status</label>
                                <select name="status" class="w-full p-2 border border-gray-300 rounded-md mb-4">
                                    <option value="pending" <?php echo $task['status'] == 'pending' ? 'selected' : ''; ?>>Pending
                                    </option>
                                    <option value="in_progress" <?php echo $task['status'] == 'in_progress' ? 'selected' : ''; ?>>
                                        In Progress</option>
                                    <option value="completed" <?php echo $task['status'] == 'completed' ? 'selected' : ''; ?>>
                                        Completed</option>
                                </select>
                                <button type="submit"
                                    class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">Update</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-700">No tasks assigned to you yet.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>

</html>