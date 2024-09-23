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
                    <a href="join_workgroups.php" class="block p-3 rounded hover:bg-blue-700 transition">Join
                        Workgroups</a>
                </li>
                <li>
                    <a href="update_tasks.php" class="block p-3 rounded hover:bg-blue-700 transition">View Tasks</a>
                </li>
                <li>
                    <a href="logout.php" class="block p-3 rounded hover:bg-blue-700 transition">Logout</a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-5 overflow-y-auto">
            <h2 class="text-2xl font-semibold">Assigned Tasks</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                <!-- Task Example -->
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-bold">Task Title</h3>
                    <p>Description of the task goes here.</p>
                    <p>Due Date: <span class="font-semibold">2024-09-30</span></p>
                    <p>Priority: <span class="font-semibold">High</span></p>
                    <div class="mt-2">
                        <label for="status-select" class="block mb-1">Update Status:</label>
                        <select id="status-select" class="border border-gray-300 rounded p-1">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        <button class="mt-2 bg-blue-600 text-white px-2 py-1 rounded">Update</button>
                    </div>
                </div>
                <!-- Repeat for each task -->
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-bold">Another Task Title</h3>
                    <p>Description of another task goes here.</p>
                    <p>Due Date: <span class="font-semibold">2024-10-05</span></p>
                    <p>Priority: <span class="font-semibold">Medium</span></p>
                    <div class="mt-2">
                        <label for="status-select-2" class="block mb-1">Update Status:</label>
                        <select id="status-select-2" class="border border-gray-300 rounded p-1">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        <button class="mt-2 bg-blue-600 text-white px-2 py-1 rounded">Update</button>
                    </div>
                </div>
                <!-- Add more task boxes as needed -->
            </div>
        </main>
    </div>
</body>

</html>