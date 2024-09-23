<?php
session_start();
require 'connection.php'; // Assuming this connects to your database

// Initialize status variable for JavaScript handling
$changePasswordStatus = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current user's data
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
    $query = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify the current password
    if (password_verify($current_password, $hashed_password)) {
        if ($new_password === $confirm_password) {
            // Hash the new password
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_query = "UPDATE users SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("si", $new_hashed_password, $user_id);

            if ($update_stmt->execute()) {
                $changePasswordStatus = "success"; // Set status for JS handling
            } else {
                $changePasswordStatus = "error"; // Set status for JS handling
            }
            $update_stmt->close();
        } else {
            $changePasswordStatus = "mismatch"; // New passwords do not match
        }
    } else {
        $changePasswordStatus = "wrong_password"; // Current password is incorrect
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert for custom popup -->
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

        <main class="flex-1 flex items-center justify-center p-5 overflow-y-auto">
            <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Change Password</h2>

                <form id="changePasswordForm" method="POST">
                    <div class="mb-4">
                        <label for="current_password" class="block text-gray-600 font-medium mb-2">Current
                            Password</label>
                        <input type="password" id="current_password" name="current_password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="new_password" class="block text-gray-600 font-medium mb-2">New Password</label>
                        <input type="password" id="new_password" name="new_password" required minlength="6"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="block text-gray-600 font-medium mb-2">Confirm New
                            Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="mb-6">
                        <button type="submit"
                            class="w-full bg-blue-600 text-white font-medium py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>


            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    // Handle the PHP response with a SweetAlert popup and page refresh if successful
                    <?php if ($changePasswordStatus == "success"): ?>
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your password has been changed successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload(); // Refresh the page
                        });
                    <?php elseif ($changePasswordStatus == "mismatch"): ?>
                        Swal.fire({
                            title: 'Error!',
                            text: 'New passwords do not match.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    <?php elseif ($changePasswordStatus == "wrong_password"): ?>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Your current password is incorrect.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    <?php elseif ($changePasswordStatus == "error"): ?>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    <?php endif; ?>
                });
            </script>
        </main>
    </div>
</body>

</html>