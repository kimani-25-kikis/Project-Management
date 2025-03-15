<?php
include 'db.php';

$sql = "SELECT * FROM projects";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Project ID: " . $row["projectID"] . " | Title: " . $row["title"] . " | Priority: " . $row["priority"] . " | Price: $" . $row["price"] . "<br>";
    }
} else {
    echo "No projects found.";
}

$conn->close();
?>
