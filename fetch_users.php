<?php
include 'connection.php';

if (isset($_POST['workgroup_id'])) {
    $workgroup_id = $_POST['workgroup_id'];

    // Fetch users belonging to the selected workgroup
    $usersResult = $conn->query("SELECT id, name FROM users WHERE workgroup = '$workgroup_id'");

    if ($usersResult->num_rows > 0) {
        while ($row = $usersResult->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }
    } else {
        echo "<option value=''>No users found in this workgroup</option>";
    }
}
