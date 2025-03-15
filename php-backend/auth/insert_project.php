<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $department = $_POST['department'];
    $priority = $_POST['priority'];
    $client_name = $_POST['client_name'];
    $price = $_POST['price'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $team = $_POST['team'];

    $sql = "INSERT INTO projects (title, department, priority, client_name, price, startdate, enddate, team) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdsss", $title, $department, $priority, $client_name, $price, $startdate, $enddate, $team);

    if ($stmt->execute()) {
        echo "Project added successfully";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
