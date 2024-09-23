<?php
session_start();
if ($_SESSION['role'] == "team_member") {
    header("Location: login.php");
} else {
    $loggedInUsr = $_SESSION['username'];
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Team Leader Dashboard | Task Management</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>

    <body class="bg-gray-100">

        <nav class="bg-blue-600 p-4 flex justify-between items-center">
            <div class="text-white text-xl font-bold">TGM - Task Group Management</div>
            <div class="text-white text-2xl">
                Welcome, <span id="username" class="font-semibold"><?= $loggedInUsr; ?>!</span>
            </div>
        </nav>

        <!-- Sidebar -->
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

            <main class="flex-1 p-6">
                <h1 class="text-2xl font-bold text-gray-800">Team Leader Dashboard</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                        <div class="w-16 h-16 bg-blue-100 text-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold">Total Users</h2>
                            <p class="text-gray-600 text-lg">
                                <?php echo $totalUsers ?? '0'; ?>
                            </p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                        <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-layer-group fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold">Total Workgroups</h2>
                            <p class="text-gray-600 text-lg">
                                <?php echo $totalWorkgroups ?? '0'; ?>
                            </p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                        <div class="w-16 h-16 bg-purple-100 text-purple-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-tasks fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold">Total Tasks</h2>
                            <p class="text-gray-600 text-lg">
                                <?php echo $totalTasks ?? '0'; ?>
                            </p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                        <div class="w-16 h-16 bg-yellow-100 text-yellow-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-hourglass-half fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold">Pending Tasks</h2>
                            <p class="text-gray-600 text-lg">
                                <?php echo $totalPendingTasks ?? '0'; ?>
                            </p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                        <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold">Completed Tasks</h2>
                            <p class="text-gray-600 text-lg">
                                <?php echo $totalCompletedTasks ?? '0'; ?>
                            </p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                        <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-circle fa-2x"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold">Delayed Tasks</h2>
                            <p class="text-gray-600 text-lg">
                                <?php echo $totalDelayedTasks ?? '0'; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>

    </html>
    <?php
}
?>