<?php
// Database connection
$db_host = 'localhost';
$db_user = 'root'; // Replace with your MySQL username
$db_pass = ''; // Replace with your MySQL password
$db_name = 'holiday_manager';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch holidays
$stmt = $pdo->query("SELECT * FROM holidays");
$holidays = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['download'])) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="holidays.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Holiday Name', 'Shift', 'Date', 'Holiday Type', 'Created By', 'Creation Date', 'Approval Status', 'Details']);
        foreach ($holidays as $holiday) {
            fputcsv($output, $holiday);
        }
        fclose($output);
        exit;
    } elseif (isset($_POST['delete'])) {
        $id = (int)$_POST['delete'];
        $stmt = $pdo->prepare("DELETE FROM holidays WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: holidays.php"); // Refresh page
        exit;
    } elseif (isset($_POST['add_holiday'])) {
        $name = trim($_POST['name']);
        $shift = trim($_POST['shift']);
        $date = $_POST['date'];
        $type = trim($_POST['type']);
        $created_by = trim($_POST['created_by']);
        $details = trim($_POST['details']);
        
        if (!empty($name) && !empty($shift) && !empty($date) && !empty($type) && !empty($created_by)) {
            $stmt = $pdo->prepare("INSERT INTO holidays (name, shift, date, type, created_by, creation_date, approval_status, details) VALUES (?, ?, ?, ?, ?, CURDATE(), 'Pending', ?)");
            $stmt->execute([$name, $shift, $date, $type, $created_by, $details]);
            header("Location: holidays.php");
            exit;
        }
    } elseif (isset($_POST['edit_holiday'])) {
        $id = (int)$_POST['edit_id'];
        $name = trim($_POST['name']);
        $shift = trim($_POST['shift']);
        $date = $_POST['date'];
        $type = trim($_POST['type']);
        $approval_status = $_POST['approval_status'];
        $details = trim($_POST['details']);
        
        if (!empty($name) && !empty($shift) && !empty($date) && !empty($type)) {
            $stmt = $pdo->prepare("UPDATE holidays SET name = ?, shift = ?, date = ?, type = ?, approval_status = ?, details = ? WHERE id = ?");
            $stmt->execute([$name, $shift, $date, $type, $approval_status, $details, $id]);
            header("Location: holidays.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Holidays</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-4">
        <h2>All Holidays</h2>

        <div class="card">
            <div>
                <!-- Header -->
                <div class="head bg-light d-flex flex-row justify-content-between align-items-center p-3">
                    <div class="d-flex flex-row align-items-center gap-2">
                        <p class="mb-0 fw-bold">Holidays</p>
                        <form method="GET" action="" class="d-flex">
                            <input type="text" class="form-control" placeholder="Search..." id="holiday" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"/>
                        </form>
                    </div>
                    <div class="d-flex gap-5">
                        <span class="text-primary" title="Filter" style="cursor: pointer;">☰</span>
                        <span class="text-success" title="Add Holiday" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#addHolidayModal">✚</span>
                        <span class="text-secondary" title="Refresh" style="cursor: pointer;" onclick="window.location.reload();">⟳</span>
                        <form method="POST" action="" class="d-inline">
                            <button type="submit" name="download" class="btn p-0 bg-transparent border-0" title="Download">
                                <span class="text-info">⤓</span>
                            </button>
                        </form>
                    </div>
                </div>
    
                <!-- Body -->
                <div class="body p-3">
                    <table class="table table-striped">
                        <thead>
                            <tr class="fw-bold">
                                <th>Holiday Name</th>
                                <th>Shift</th>
                                <th>Date</th>
                                <th>Holiday Type</th>
                                <th>Created By</th>
                                <th>Creation Date</th>
                                <th>Approval Status</th>
                                <th>Details</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $filtered_holidays = $holidays;
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search = strtolower($_GET['search']);
                                $filtered_holidays = array_filter($holidays, function($holiday) use ($search) {
                                    return strpos(strtolower($holiday['name']), $search) !== false ||
                                           strpos(strtolower($holiday['type']), $search) !== false ||
                                           strpos(strtolower($holiday['created_by']), $search) !== false;
                                });
                            }
                            foreach ($filtered_holidays as $holiday): 
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($holiday['name']); ?></td>
                                    <td><?php echo htmlspecialchars($holiday['shift']); ?></td>
                                    <td><?php echo htmlspecialchars($holiday['date']); ?></td>
                                    <td><?php echo htmlspecialchars($holiday['type']); ?></td>
                                    <td><?php echo htmlspecialchars($holiday['created_by']); ?></td>
                                    <td><?php echo htmlspecialchars($holiday['creation_date']); ?></td>
                                    <td>
                                        <span class="badge <?php echo $holiday['approval_status'] === 'Approved' ? 'bg-success' : 'bg-warning'; ?> fs-6">
                                            <?php echo htmlspecialchars($holiday['approval_status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <p style="max-lines: 1; overflow: hidden; white-space: nowrap;">
                                            <?php echo htmlspecialchars($holiday['details']); ?>
                                        </p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row gap-4">
                                            <span class="text-primary" title="Edit" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#editHolidayModal" onclick="populateEditModal(<?php echo $holiday['id']; ?>, '<?php echo htmlspecialchars(json_encode($holiday)); ?>')">✎</span>
                                            <form method="POST" action="" class="d-inline">
                                                <button type="submit" name="delete" value="<?php echo $holiday['id']; ?>" class="btn p-0 bg-transparent border-0" title="Delete" onclick="return confirm('Are you sure you want to delete this holiday?');">
                                                    <span class="text-danger">🗑️</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Holiday Modal -->
    <div class="modal fade" id="addHolidayModal" tabindex="-1" aria-labelledby="addHolidayModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addHolidayModalLabel">Add Holiday</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Holiday Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="shift" class="form-label">Shift <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="shift" name="shift" required>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Holiday Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="National">National</option>
                                <option value="Religious">Religious</option>
                                <option value="Company">Company</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="created_by" class="form-label">Created By <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="created_by" name="created_by" required>
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Details</label>
                            <textarea class="form-control" id="details" name="details" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="add_holiday" class="btn btn-primary">Add Holiday</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Holiday Modal -->
    <div class="modal fade" id="editHolidayModal" tabindex="-1" aria-labelledby="editHolidayModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editHolidayModalLabel">Edit Holiday</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Holiday Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_shift" class="form-label">Shift <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_shift" name="shift" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edit_date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_type" class="form-label">Holiday Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_type" name="type" required>
                                <option value="National">National</option>
                                <option value="Religious">Religious</option>
                                <option value="Company">Company</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_approval_status" class="form-label">Approval Status</label>
                            <select class="form-select" id="edit_approval_status" name="approval_status">
                                <option value="Approved">Approved</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_details" class="form-label">Details</label>
                            <textarea class="form-control" id="edit_details" name="details" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="edit_holiday" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function populateEditModal(id, holidayJson) {
            const holiday = JSON.parse(holidayJson);
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = holiday.name;
            document.getElementById('edit_shift').value = holiday.shift;
            document.getElementById('edit_date').value = holiday.date; // Already in YYYY-MM-DD format from DB
            document.getElementById('edit_type').value = holiday.type;
            document.getElementById('edit_approval_status').value = holiday.approval_status;
            document.getElementById('edit_details').value = holiday.details || '';
        }
    </script>
</body>
</html>