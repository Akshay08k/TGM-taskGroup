<?php
include 'connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'An error occurred.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id'])) {
        $id = $input['id'];

        $query = "DELETE FROM tasks WHERE id='$id'";

        if ($conn->query($query) === TRUE) {
            $response = ['success' => true];
        } else {
            $response['message'] = 'Delete failed: ' . $conn->error;
        }
    } else {
        $response['message'] = 'Invalid input.';
    }
}

echo json_encode($response);
$conn->close();
