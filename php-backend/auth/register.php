<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get raw POST data (JSON support)
    $postData = file_get_contents("php://input");
    $data = json_decode($postData, true);

    // Use either $_POST (FormData) or JSON input
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : trim($data["username"]);
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : trim($data["email"]);
    $role = isset($_POST["role"]) ? trim($_POST["role"]) : trim($data["role"]);
    $password = isset($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_BCRYPT) : password_hash($data["password"], PASSWORD_BCRYPT);

    // Check if email already exists
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Email already exists!"]);
    } else {
        // Insert into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $role);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "User registered successfully!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
        }

        $stmt->close();
    }

    $check_email->close();
    $conn->close();
}
?>
