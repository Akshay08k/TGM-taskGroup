<?php
include 'connection.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'An error occurred.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id'])) {
        $id = $input['id'];
        $query = "DELETE FROM workgroup_members WHERE member_id='$id'"; // Adjust table and column names accordingly

        if ($conn->query($query) === TRUE) {
            $response['success'] = true;
        } else {
            $response['message'] = 'Delete failed: ' . $conn->error;
        }
    } else {
        $response['message'] = 'Invalid input.';
    }
}

echo json_encode($response);
$conn->close();
