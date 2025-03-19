<?php
// Start session to store project data temporarily
session_start();

// Initialize projects array if not set
if (!isset($_SESSION['projects'])) {
    $_SESSION['projects'] = [];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $projid = $_POST['projid'] ?? '';
    $projtitle = $_POST['projtitle'] ?? '';
    $department = $_POST['department'] ?? '';
    $priority = $_POST['priority'] ?? '';
    $client = $_POST['client'] ?? '';
    $price = $_POST['price'] ?? '';
    $startdate = $_POST['startdate'] ?? '';
    $enddate = $_POST['enddate'] ?? '';
    $team = $_POST['team'] ?? '';

    // Basic validation (optional, but recommended)
    if (!empty($projid) && !empty($projtitle)) {
        // Store project in session array
        $_SESSION['projects'][] = [
            'projid' => $projid,
            'projtitle' => $projtitle,
            'department' => $department,
            'priority' => $priority,
            'client' => $client,
            'price' => $price,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'team' => $team
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Projects</title>
    <!-- Bootstrap CSS (assuming you used it; link to CDN for simplicity) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <p class="h4">Add Projects</p>

        <div class="card bg-white">
            <div class="card-body">
                <p class="h5">Add Projects</p>

                <!-- Form now submits to itself -->
                <form action="" method="POST" class="d-flex flex-wrap justify-content-center align-items-center mt-2">
                    <div class="form-floating mt-3 mb-3 w-50 p-2">
                        <input type="text" class="form-control" id="projid" placeholder="Project ID" name="projid" value="<?php echo isset($_POST['projid']) ? htmlspecialchars($_POST['projid']) : ''; ?>">
                        <label for="projid">Project ID</label>
                    </div>
                    
                    <div class="form-floating mt-3 mb-3 w-50">
                        <input type="text" class="form-control" id="projtitle" placeholder="Project Title" name="projtitle" value="<?php echo isset($_POST['projtitle']) ? htmlspecialchars($_POST['projtitle']) : ''; ?>">
                        <label for="projtitle">Project Title:</label>
                    </div>
                    
                    <div class="mb-3 w-50 px-4 px-md-2">
                        <label for="department" class="form-label">Department</label>
                        <select class="form-select" id="department" name="department">
                            <option <?php echo (isset($_POST['department']) && $_POST['department'] === 'IT') ? 'selected' : ''; ?>>IT</option>
                            <option <?php echo (isset($_POST['department']) && $_POST['department'] === 'Hospitality') ? 'selected' : ''; ?>>Hospitality</option>
                            <option <?php echo (isset($_POST['department']) && $_POST['department'] === 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
                            <option <?php echo (isset($_POST['department']) && $_POST['department'] === 'Construction') ? 'selected' : ''; ?>>Construction</option>
                        </select>
                    </div>
                    
                    <div class="mb-3 w-50 px-4 px-md-2">
                        <label for="priority" class="form-label">Project Priority</label>
                        <select class="form-select" id="priority" name="priority">
                            <option <?php echo (isset($_POST['priority']) && $_POST['priority'] === 'High') ? 'selected' : ''; ?>>High</option>
                            <option <?php echo (isset($_POST['priority']) && $_POST['priority'] === 'Medium') ? 'selected' : ''; ?>>Medium</option>
                            <option <?php echo (isset($_POST['priority']) && $_POST['priority'] === 'Low') ? 'selected' : ''; ?>>Low</option>
                        </select>
                    </div>
                    
                    <div class="form-floating mt-3 mb-3 w-50 p-2">
                        <input type="text" class="form-control" id="client" placeholder="Client Name" name="client" value="<?php echo isset($_POST['client']) ? htmlspecialchars($_POST['client']) : ''; ?>">
                        <label for="client">Client Name:</label>
                    </div>
                    
                    <div class="form-floating mt-3 mb-3 w-50">
                        <input type="number" class="form-control" id="price" placeholder="Project Price" name="price" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>">
                        <label for="price">Project Price($):</label>
                    </div>
                    
                    <div class="mb-3 w-50 px-4 px-md-2">
                        <label for="startdate" class="form-label">Project Start Date:</label>
                        <input type="date" class="form-control" id="startdate" name="startdate" value="<?php echo isset($_POST['startdate']) ? htmlspecialchars($_POST['startdate']) : ''; ?>">
                    </div>
                    
                    <div class="mb-3 w-50 px-4 px-md-2">
                        <label for="enddate" class="form-label">Project End Date:</label>
                        <input type="date" class="form-control" id="enddate" name="enddate" value="<?php echo isset($_POST['enddate']) ? htmlspecialchars($_POST['enddate']) : ''; ?>">
                    </div>
                    
                    <div class="mb-3 w-100 px-4 px-md-2">
                        <label for="team" class="form-label">Team</label>
                        <select class="form-select" id="team" name="team">
                            <option <?php echo (isset($_POST['team']) && $_POST['team'] === 'Developers') ? 'selected' : ''; ?>>Developers</option>
                            <option <?php echo (isset($_POST['team']) && $_POST['team'] === 'Engineers') ? 'selected' : ''; ?>>Engineers</option>
                            <option <?php echo (isset($_POST['team']) && $_POST['team'] === 'Architects') ? 'selected' : ''; ?>>Architects</option>
                        </select>
                    </div>
                    
                    <div class="w-100 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                <!-- Display submitted projects -->
                <?php if (!empty($_SESSION['projects'])): ?>
                    <div class="mt-4">
                        <h5>Submitted Projects</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Department</th>
                                    <th>Priority</th>
                                    <th>Client</th>
                                    <th>Price</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Team</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['projects'] as $project): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($project['projid']); ?></td>
                                        <td><?php echo htmlspecialchars($project['projtitle']); ?></td>
                                        <td><?php echo htmlspecialchars($project['department']); ?></td>
                                        <td><?php echo htmlspecialchars($project['priority']); ?></td>
                                        <td><?php echo htmlspecialchars($project['client']); ?></td>
                                        <td><?php echo htmlspecialchars($project['price']); ?></td>
                                        <td><?php echo htmlspecialchars($project['startdate']); ?></td>
                                        <td><?php echo htmlspecialchars($project['enddate']); ?></td>
                                        <td><?php echo htmlspecialchars($project['team']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for some form features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>