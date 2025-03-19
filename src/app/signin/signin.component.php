<?php
session_start();

// Database connection
$db_host = 'localhost';
$db_user = 'root'; // Replace with your MySQL username
$db_pass = ''; // Replace with your MySQL password
$db_name = 'project_manager';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password) || empty($role)) {
        $error = 'All fields are required.';
    } else {
        // Check credentials
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
        $stmt->execute([$email, $role]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            header("Location: dashboard.php"); // Redirect to a dashboard page
            exit;
        } else {
            $error = 'Invalid email, role, or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card { max-width: 50%; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="card p-4 m-3 mx-auto">
        <div class="card-head">
            <p class="text-primary h3">Login</p>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="mb-3 w-100 px-4 px-md-2">
                    <label for="role" class="form-label">Select Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="Admin" <?php echo (isset($_POST['role']) && $_POST['role'] === 'Admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="Manager" <?php echo (isset($_POST['role']) && $_POST['role'] === 'Manager') ? 'selected' : ''; ?>>Manager</option>
                        <option value="Employee" <?php echo (isset($_POST['role']) && $_POST['role'] === 'Employee') ? 'selected' : ''; ?>>Employee</option>
                    </select>
                </div>
                <div class="form-floating mt-3 mb-3">
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    <label for="email" class="form-label">Enter Email</label>
                </div>
                <div class="form-floating mt-3 mb-3">
                    <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" required>
                    <label for="password" class="form-label">Password</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            
            <p class="mt-3 text-center">
                <a href="forgot_password.php" class="text-decoration-none">Forgot Password?</a>
            </p>
            <p class="text-center">
                Don't have an account? <a href="signup.php" class="text-decoration-none">Sign up</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>