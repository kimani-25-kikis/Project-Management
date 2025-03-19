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

// Fetch project (assuming ID 1 for this example; use GET parameter in a real app)
$project_id = 1; // Could be $_GET['id'] in a multi-project app
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$project_id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch client
$stmt = $pdo->prepare("SELECT * FROM clients WHERE project_id = ?");
$stmt->execute([$project_id]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch latest message
$stmt = $pdo->prepare("SELECT * FROM messages WHERE project_id = ? ORDER BY timestamp DESC LIMIT 1");
$stmt->execute([$project_id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle edit form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_project'])) {
    $name = trim($_POST['name']);
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];
    $version = trim($_POST['version']);
    $team = trim($_POST['team']);
    $progress = (int)$_POST['progress'];
    $description = trim($_POST['description']);
    
    if (!empty($name) && !empty($deadline)) {
        $stmt = $pdo->prepare("UPDATE projects SET name = ?, status = ?, deadline = ?, version = ?, team = ?, progress = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $status, $deadline, $version, $team, $progress, $description, $project_id]);
        header("Location: project_details.php"); // Refresh page
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <p>Project Details</p>

        <div class="d-flex flex-row m-2">
            <div class="card col-12 col-md-9 me-3">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                        <p class="h3 text-warning"><?php echo htmlspecialchars($project['name']); ?></p>
                        <button class="btn btn-link text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#editProjectModal">Edit project</button>
                    </div>

                    <p>Status: <span class="badge <?php echo $project['status'] === 'Active' ? 'bg-success' : ($project['status'] === 'Completed' ? 'bg-primary' : 'bg-secondary'); ?>"><?php echo htmlspecialchars($project['status']); ?></span></p>
                    <div>
                        <table class="table">
                            <tr>
                                <td>Created by:</td>
                                <td>Last Updated: <?php echo htmlspecialchars($project['last_updated']); ?></td>
                            </tr>
                            <tr>
                                <td>Messages: <?php echo htmlspecialchars($project['messages_count']); ?></td>
                                <td>Created: <?php echo htmlspecialchars($project['created_date']); ?></td>
                            </tr>
                            <tr>
                                <td>Commits: <?php echo htmlspecialchars($project['commits_count']); ?></td>
                                <td>Deadline: <?php echo htmlspecialchars($project['deadline']); ?></td>
                            </tr>
                            <tr>
                                <td>Version: <?php echo htmlspecialchars($project['version']); ?></td>
                                <td>Team: <?php echo htmlspecialchars($project['team']); ?></td>
                            </tr>
                        </table>

                        <div class="d-flex align-items-center">
                            <span class="fw-bold p-3">Project Status:</span>
                            <div class="progress flex-grow-1 me-3" style="height: 5px;">
                                <div class="progress-bar bg-primary" style="width: <?php echo $project['progress']; ?>%;"></div>
                            </div>
                        </div>
                        <span class="fw-bold fs-3 p-3"><?php echo $project['progress']; ?>% <span class="text-secondary fs-5">Project Completed.</span></span>
                        
                        <div class="card mt-3">
                            <div class="body p-3">
                                <span class="btn btn-secondary">
                                    Messages <span class="badge bg-danger"><?php echo $project['messages_count'] > 0 ? 4 : 0; ?></span>
                                </span>

                                <?php if ($message): ?>
                                    <div class="d-flex flex-row align-items-start mt-2">
                                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded-circle" style="height: 30px; width: 50px;"></div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="mb-1 fw-bold"><?php echo htmlspecialchars($message['sender']); ?></p>
                                            <p class="mb-0 text-muted"><?php echo htmlspecialchars($message['content']); ?></p>
                                        </div>
                                        <div class="ms-3 text-muted">
                                            <p class="mb-0"><?php echo date('H[h] \a\g\o', strtotime($message['timestamp'])); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3 p-3">
                <div class="card d-flex flex-column m-2">
                    <div class="card-body">
                        <p class="h4">Project Description</p>
                        <p class="text-justify text-wrap"><?php echo htmlspecialchars($project['description']); ?></p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <p>Client Details</p>
                        <p class="fw-bold">Client: <span class="fw-normal"><?php echo htmlspecialchars($client['name']); ?></span></p>
                        <p class="fw-bold">Email: <span class="fw-normal"><?php echo htmlspecialchars($client['email']); ?></span></p>
                        <p class="fw-bold">Payment Status: <span class="fw-normal"><?php echo htmlspecialchars($client['payment_status']); ?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Project Modal -->
    <div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProjectModalLabel">Edit Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Project Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($project['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="Active" <?php echo $project['status'] === 'Active' ? 'selected' : ''; ?>>Active</option>
                                <option value="Inactive" <?php echo $project['status'] === 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                                <option value="Completed" <?php echo $project['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deadline" class="form-label">Deadline <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="deadline" name="deadline" value="<?php echo htmlspecialchars($project['deadline']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="version" class="form-label">Version</label>
                            <input type="text" class="form-control" id="version" name="version" value="<?php echo htmlspecialchars($project['version']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="team" class="form-label">Team</label>
                            <input type="text" class="form-control" id="team" name="team" value="<?php echo htmlspecialchars($project['team']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="progress" class="form-label">Progress (%)</label>
                            <input type="number" class="form-control" id="progress" name="progress" min="0" max="100" value="<?php echo htmlspecialchars($project['progress']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5"><?php echo htmlspecialchars($project['description']); ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="edit_project" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>