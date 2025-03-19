<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Determine which page to display (simulating router-outlet)
$page = $_GET['page'] ?? 'dashboard'; // Default to dashboard
$content_file = '';
switch ($page) {
    case 'dashboard':
        $content_file = 'dashboard.php';
        break;
    case 'projects':
        $content_file = 'projects_overview.php';
        break;
    case 'login':
        header("Location: login.php"); // Redirect to login if already logged in
        exit;
    default:
        $content_file = 'dashboard.php'; // Fallback
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .navbar {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar (replacing <app-navbar>) -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Project Manager</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=projects">Projects</a>
                    </li>
                </ul>
                <span class="navbar-text me-3">
                    Welcome, <?php echo htmlspecialchars($_SESSION['role']); ?>
                </span>
                <a href="logout.php" class="btn btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main content area -->
    <main class="main">
        <!-- Sidebar (replacing <app-sidebar>) -->
        <div class="sidebar">
            <h4>Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=projects">Projects Overview</a>
                </li>
                <!-- Add more links as needed -->
            </ul>
        </div>

        <!-- Content area (replacing <router-outlet>) -->
        <div class="content">
            <?php
            if (file_exists($content_file)) {
                include $content_file;
            } else {
                echo "<p>Page not found.</p>";
            }
            ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>