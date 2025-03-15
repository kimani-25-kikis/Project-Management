<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $holiday_name = $_POST['holiday_name'];
    $shift = $_POST['shift'];
    $date = $_POST['date'];
    $holiday_type = $_POST['holiday_type'];
    $created_by = $_POST['created_by'];
    $approval_status = $_POST['approval_status'];
    $details = $_POST['details'];

    $sql = "INSERT INTO holiday (holiday_name, shift, date, holiday_type, created_by, approval_status, details) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $holiday_name, $shift, $date, $holiday_type, $created_by, $approval_status, $details);

    if ($stmt->execute()) {
        echo "Holiday added successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
