<?php
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

// Fetch all projects
$stmt = $pdo->query("SELECT * FROM projects");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group projects by status
$overview = [
    'New' => [],
    'Running' => [],
    'On Hold' => [],
    'Finished' => []
];
foreach ($projects as $project) {
    $overview[$project['status']][] = $project;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Projects Overview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <p>All Projects Overview</p>

        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row w-100 justify-content-between flex-wrap">
                    <!-- New Projects -->
                    <div class="mb-3">
                        <p class="h4">New Projects</p>
                        <p class="text-secondary"><?php echo count($overview['New']); ?> projects</p>
                    </div>

                    <!-- Running Projects -->
                    <div class="mb-3">
                        <p class="h4">Running</p>
                        <p class="text-secondary"><?php echo count($overview['Running']); ?> project<?php echo count($overview['Running']) !== 1 ? 's' : ''; ?></p>
                        <?php foreach ($overview['Running'] as $project): ?>
                            <div class="card bg-light p-4 mt-2">
                                <div class="body">
                                    <p class="fw-bold"><?php echo htmlspecialchars($project['name']); ?></p>
                                    <div class="d-flex flex-row justify-content-between">
                                        <p><?php echo htmlspecialchars($project['open_tasks']); ?> open tasks</p>
                                        <a href="project_details.php?id=<?php echo $project['id']; ?>" class="btn bg-primary text-light"><?php echo htmlspecialchars($project['type']); ?></a>
                                    </div>
                                    <p><?php echo htmlspecialchars($project['description']); ?></p>
                                    <p class="fw-bold"><span class="fw-normal">at: <?php echo date('M d, Y', strtotime($project['created_date'])); ?></span></p>
                                    <p class="fw-bold">Team Leader: <span class="fw-normal"><?php echo htmlspecialchars($project['team_leader']); ?></span></p>
                                    <p class="fw-bold">Priority: <span class="fw-normal"><?php echo htmlspecialchars($project['priority']); ?></span></p>
                                    <p class="fw-bold">Deadline: <span class="fw-normal"><?php echo date('M d, Y', strtotime($project['deadline'])); ?></span></p>
                                    <p class="fw-bold">Comments: <span class="fw-normal"><?php echo htmlspecialchars($project['comments_count']); ?></span></p>
                                    <p class="fw-bold">Bug: <span class="fw-normal"><?php echo htmlspecialchars($project['bugs_count']); ?></span></p>
                                    <p class="fw-bold">Team: <span class="fw-normal"><?php echo htmlspecialchars($project['team']); ?></span></p>

                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold p-3">Project Status:</span>
                                        <div class="progress flex-grow-1 me-3" style="height: 5px;">
                                            <div class="progress-bar bg-primary" style="width: <?php echo $project['progress']; ?>%;"></div>
                                        </div>
                                    </div>
                                    <span class="fw-bold fs-5 p-3"><?php echo $project['progress']; ?>% <span class="text-secondary fs-6">Project Completed.</span></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- On Hold Projects -->
                    <div class="mb-3">
                        <p class="h4">On Hold</p>
                        <p class="text-secondary"><?php echo count($overview['On Hold']); ?> project<?php echo count($overview['On Hold']) !== 1 ? 's' : ''; ?></p>
                    </div>

                    <!-- Finished Projects -->
                    <div class="mb-3">
                        <p class="h4">Finished</p>
                        <p class="text-secondary"><?php echo count($overview['Finished']); ?> projects</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>