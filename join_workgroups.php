<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Workgroups</title>
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
            <h2 class="text-2xl font-semibold">Join Workgroup</h2>
            <form method="POST" action="/join_workgroup" class="mt-4 bg-white p-4 rounded-lg shadow-md">
                <label for="invite_code" class="block text-gray-600 font-medium mb-2">Enter Invite Code:</label>
                <input type="text" id="invite_code" name="invite_code" placeholder="Enter Invite Code" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                    class="mt-4 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Join</button>
            </form>

            <!-- Additional Content -->
            <div class="mt-6">
                <h3 class="text-xl font-semibold">Available Workgroups</h3>
                <ul class="space-y-2 mt-2">
                    <!-- Example Workgroup -->
                    <li class="bg-white p-4 rounded-lg shadow-md">
                        <h4 class="font-bold">Workgroup Name</h4>
                        <p class="text-gray-700">Invite Code: [Invite Code]</p>
                        <a href="#" class="text-blue-600 hover:underline">Join Now</a>
                    </li>
                </ul>
            </div>
        </main>
    </div>
</body>

</html>