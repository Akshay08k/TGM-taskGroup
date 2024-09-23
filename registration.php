<?php
include 'connection.php';

$registrationStatus = ""; // Default status

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $_POST['role']; // Capture the selected role

    // Insert into the database
    $sql = "INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $phone, $password, $role);

    if ($stmt->execute()) {
        $registrationStatus = "success"; // Set status to success
    } else {
        $registrationStatus = "error"; // Set status to error
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Registration | Task Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <!-- Registration Form -->
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Team Leader Registration</h2>

        <form id="registrationForm" method="POST" novalidate>
            <div class="mb-4">
                <label for="name" class="block text-gray-600 font-medium mb-2">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-600 font-medium mb-2">Email Address</label>
                <input type="email" id="email" name="email" placeholder="teamleader@example.com" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-600 font-medium mb-2">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="+1234567890" required pattern="^\+?\d{10,}$"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-600 font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" placeholder="********" required minlength="6"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="confirm_password" class="block text-gray-600 font-medium mb-2">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="********" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="role" class="block text-gray-600 font-medium mb-2">Select Role</label>
                <select id="role" name="role" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="team_leader">Team Leader</option>
                    <option value="team_member">Team Member</option>
                </select>
            </div>

            <div class="mb-6">
                <button type="submit"
                    class="w-full bg-green-600 text-white font-medium py-2 rounded-md hover:bg-green-700 transition duration-300">Register</button>
            </div>

            <div class="text-center">
                <a href="login.php" class="text-blue-600 hover:underline">Already have an account? Login</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Handle PHP response (success or error) using JavaScript
            <?php if ($registrationStatus == "success"): ?>
                Swal.fire({
                    title: 'Success!',
                    text: 'Registration successful!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            <?php elseif ($registrationStatus == "error"): ?>
                Swal.fire({
                    title: 'Error!',
                    text: 'Error during registration. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        });
    </script>

</body>

</html>