<?php
session_start();
require 'connection.php'; // Assume you have this to connect to your database

// Fetch current user ID (from session)
$user_id = $_SESSION['user_id']; // Adjust according to your session setup

// Fetch workgroups the user has already joined
$query = "SELECT w.name, w.invite_code 
          FROM workgroups w
          INNER JOIN users u ON u.workgroup = w.id 
          WHERE u.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$workgroups = $result->fetch_all(MYSQLI_ASSOC);

// If form is submitted, process invite code to join new workgroup
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $invite_code = $_POST['invite_code'];

    // Check if the invite code exists
    $check_query = "SELECT id FROM workgroups WHERE invite_code = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $invite_code);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // If workgroup exists, update the user's workgroup
        $workgroup_data = $check_result->fetch_assoc();
        $workgroup_id = $workgroup_data['id'];

        // Update user's workgroup
        $update_query = "UPDATE users SET workgroup = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ii", $workgroup_id, $user_id);

        if ($update_stmt->execute()) {
            $_SESSION['message'] = "You have successfully joined the workgroup!";
            header("Location: team_member_dashboard.php");
        } else {
            $_SESSION['error'] = "Failed to join workgroup. Try again.";
        }
    } else {
        $_SESSION['error'] = "Invalid invite code.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
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

        <main class="flex-1 p-5 overflow-y-auto">
            <h2 class="text-2xl font-semibold">Welcome,
                <?php echo $_SESSION['username']; // Display logged-in member name ?>
            </h2>

            <!-- Display any messages -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    <?php echo $_SESSION['message'];
                    unset($_SESSION['message']); ?>
                </div>
            <?php elseif (isset($_SESSION['error'])): ?>
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="mt-6">
                <h3 class="text-xl font-semibold mb-4">Your Workgroups</h3>
                <ul class="space-y-2">
                    <?php if (!empty($workgroups)): ?>
                        <?php foreach ($workgroups as $workgroup): ?>
                            <li class="bg-white p-4 rounded-lg shadow-md">
                                <h4 class="font-bold"><?php echo htmlspecialchars($workgroup['name']); ?></h4>
                                <p class="text-gray-700">Invite Code: <?php echo htmlspecialchars($workgroup['invite_code']); ?>
                                </p>

                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="bg-white p-4 rounded-lg shadow-md">
                            <p class="text-gray-700">You haven't joined any workgroups yet.</p>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="mt-6">
                <h3 class="text-xl font-semibold mb-4">Join a New Workgroup</h3>
                <form action="team_member_dashboard.php" method="POST" class="bg-white p-4 rounded-lg shadow-md">
                    <label for="invite_code" class="block text-gray-600 font-medium mb-2">Enter Invite Code:</label>
                    <input type="text" id="invite_code" name="invite_code" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="mt-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Join
                        Workgroup</button>
                </form>
            </div>
        </main>
    </div>
</body>

</html>