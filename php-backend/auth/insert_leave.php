<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_name = $_POST['employee_name'];
    $employee_id = $_POST['employee_id'];
    $department = $_POST['department'];
    $leave_type = $_POST['leave_type'];
    $leave_from = $_POST['leave_from'];
    $leave_to = $_POST['leave_to'];
    $days = $_POST['days'];
    $duration_type = $_POST['duration_type'];
    $status = $_POST['status'];

    $sql = "INSERT INTO leave_requests (employee_name, employee_id, department, leave_type, leave_from, leave_to, days, duration_type, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssiis", $employee_name, $employee_id, $department, $leave_type, $leave_from, $leave_to, $days, $duration_type, $status);

    if ($stmt->execute()) {
        echo "Leave request added successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
