<?php

include "connection.php";

// Function to generate a random invite code
function generateInviteCode($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Check if the form is submitted to create a new workgroup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['workgroup_name'])) {
    // Get the workgroup name from the form
    $workgroupName = $_POST['workgroup_name'];

    // Check if a workgroup with the same name already exists
    $sqlCheck = "SELECT * FROM workgroups WHERE name = '$workgroupName'";
    $resultCheck = $conn->query($sqlCheck);

    if ($resultCheck->num_rows > 0) {
        echo "<script>alert('A workgroup with this name already exists! Please choose a different name.');</script>";
    } else {
        $inviteCode = generateInviteCode();
        $sqlInsert = "INSERT INTO workgroups (name, invite_code) VALUES ('$workgroupName', '$inviteCode')";

        if ($conn->query($sqlInsert) === TRUE) {
            echo "<script>alert('Workgroup created successfully! Invite code: $inviteCode');</script>";
        } else {
            echo "Error: " . $sqlInsert . "<br>" . $conn->error;
        }
    }
}

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $sqlDelete = "DELETE FROM workgroups WHERE id='$deleteId'";

    if ($conn->query($sqlDelete) === TRUE) {
        echo "<script>alert('Workgroup deleted successfully!'); window.location.href='create_workgroup.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sqlFetch = "SELECT * FROM workgroups";
$result = $conn->query($sqlFetch);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Workgroup | Task Management</title>
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

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Create a New Workgroup</h1>

            <form id="create-workgroup-form" method="POST" class="space-y-4">
                <div>
                    <label for="workgroup-name" class="block text-gray-600 font-medium">Workgroup Name</label>
                    <input type="text" id="workgroup-name" name="workgroup_name" placeholder="Enter workgroup name"
                        class="w-full border border-gray-300 rounded-md p-2" required>
                </div>

                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Create
                    Workgroup</button>
            </form>

            <h2 class="text-2xl font-bold text-gray-800 mt-12">Available Workgroups</h2>

            <!-- Display available workgroups -->
            <table class="min-w-full bg-white mt-4 border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-2 px-4 border">ID</th>
                        <th class="py-2 px-4 border">Workgroup Name</th>
                        <th class="py-2 px-4 border">Invite Code</th>
                        <th class="py-2 px-4 border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td class='py-2 px-4 border text-center'>" . $row['id'] . "</td>
                                    <td class='py-2 px-4 border text-center'>" . $row['name'] . "</td>
                                    <td class='py-2 px-4 border text-center'>" . $row['invite_code'] . "</td>
                                    <td class='py-2 px-4 border text-center'>
                                        <a href='create_workgroup.php?delete_id=" . $row['id'] . "' class='text-red-600 hover:underline'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='py-2 px-4 text-center'>No workgroups available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>

</body>

</html>