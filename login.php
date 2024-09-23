<?php
include 'connection.php';

$emailError = $passwordError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['name'];

        if ($user['role'] == 'team_leader') {
            header("Location: team_leader_dashboard.php");
        } else {
            header("Location: team_member_dashboard.php");
        }
        exit();
    } else {
        if (!$user) {
            $emailError = "Email not found!";
        } else if (!password_verify($password, $user['password'])) {
            $passwordError = "Invalid password!";
        }
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
    <title> Login | Task Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .border-red-500 {
            border-color: #f56565 !important;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700"> Login</h2>

        <!-- Display form -->
        <form id="loginForm" method="POST" novalidate>
            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-gray-600 font-medium mb-2">Email Address</label>
                <input type="email" id="email" name="email" placeholder="teamleader@example.com" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php if ($emailError)
                    echo 'border-red-500'; ?>">
                <?php if ($emailError): ?>
                    <p class="text-red-500 mt-1"><?php echo $emailError; ?></p>
                <?php endif; ?>
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label for="password" class="block text-gray-600 font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" placeholder="********" required minlength="6"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?php if ($passwordError)
                        echo 'border-red-500'; ?>">
                <?php if ($passwordError): ?>
                    <p class="text-red-500 mt-1"><?php echo $passwordError; ?></p>
                <?php endif; ?>
            </div>

            <!-- Remember Me Checkbox -->
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-blue-600">
                    <span class="ml-2 text-gray-600">Remember me</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="mb-6">
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-medium py-2 rounded-md hover:bg-blue-700 transition duration-300">Login</button>
            </div>

            <!-- Forgot Password Link -->
            <div class="text-center">
                <a href="#" class="text-blue-600 hover:underline">Forgot your password?</a>
            </div>
        </form>
    </div>

</body>

</html>