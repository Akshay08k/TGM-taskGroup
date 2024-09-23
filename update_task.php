<?php
include 'connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'An error occurred.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id'], $input['task_name'], $input['task_desc'], $input['due_date'])) {
        $id = $input['id'];
        $task_name = $conn->real_escape_string($input['task_name']);
        $task_desc = $conn->real_escape_string($input['task_desc']);
        $due_date = $conn->real_escape_string($input['due_date']);

        $query = "UPDATE tasks SET task_name='$task_name', task_desc='$task_desc', due_date='$due_date' WHERE id='$id'";

        if ($conn->query($query) === TRUE) {
            $response = ['success' => true];
        } else {
            $response['message'] = 'Update failed: ' . $conn->error;
        }
    } else {
        $response['message'] = 'Invalid input.';
    }
}

echo json_encode($response);
$conn->close();
    