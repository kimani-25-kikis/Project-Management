<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $department = $_POST['department'];
    $mobile = $_POST['mobile'];
    $joining_date = $_POST['joining_date'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    $sql = "INSERT INTO employees (name, role, department, mobile, joining_date, email, gender, address) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $name, $role, $department, $mobile, $joining_date, $email, $gender, $address);

    if ($stmt->execute()) {
        echo "Employee added successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
