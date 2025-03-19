<?php
// Start session (optional, for persistence across pages)
session_start();

// Sample holiday data (replace with database query in a real app)
$holidays = [
    [
        'name' => 'New Year',
        'shift' => 'All Shifts',
        'date' => '12/31/2021', // Corrected from '12/31/2-21'
        'type' => 'National',
        'created_by' => 'Admin',
        'creation_date' => '11/01/2021',
        'approval_status' => 'Approved',
        'details' => 'This festive season is about celebrating the new beginnings with joy and enthusiasm.'
    ],
    // Duplicate entries removed; add more unique holidays as needed
    [
        'name' => 'Christmas',
        'shift' => 'All Shifts',
        'date' => '12/25/2021',
        'type' => 'Religious',
        'created_by' => 'HR',
        'creation_date' => '11/15/2021',
        'approval_status' => 'Pending',
        'details' => 'A time for family, giving, and celebration.'
    ]
];

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['download'])) {
        // Export as CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="holidays.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Holiday Name', 'Shift', 'Date', 'Holiday Type', 'Created By', 'Creation Date', 'Approval Status', 'Details']);
        foreach ($holidays as $holiday) {
            fputcsv($output, $holiday);
        }
        fclose($output);
        exit;
    } elseif (isset($_POST['delete'])) {
        $index = (int)$_POST['delete'];
        if (isset($holidays[$index])) {
            unset($holidays[$index]);
            $holidays = array_values($holidays); // Reindex array
            $_SESSION['holidays'] = $holidays; // Store in session for persistence
        }
    }
}

// Store holidays in session (for delete persistence)
$_SESSION['holidays'] = $holidays;
$holidays = $_SESSION['holidays']; // Use session data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Holidays</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Assume custom CSS exists -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div>
        <p>All Holiday</p>

        <div class="card">
            <div>
                <!-- Header -->
                <div class="head bg-light d-flex flex-row justify-content-between align-items-center p-3">
                    <!-- Title & Search -->
                    <div class="d-flex flex-row align-items-center gap-2">
                        <p class="mb-0 fw-bold">Holidays</p>
                        <form method="GET" action="" class="d-flex">
                            <input type="text" class="form-control" placeholder="Search..." id="holiday" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"/>
                        </form>
                    </div>
    
                    <!-- Icons -->
                    <div class="d-flex gap-5">
                        <span class="text-primary" title="Filter" style="cursor: pointer;">☰</span> <!-- Filter icon -->
                        <span class="text-success" title="Add Holiday" style="cursor: pointer;" onclick="alert('Add holiday feature not implemented yet');">✚</span> <!-- Add icon -->
                        <span class="text-secondary" title="Refresh" style="cursor: pointer;" onclick="window.location.reload();">⟳</span> <!-- Refresh icon -->
                        <form method="POST" action="" class="d-inline">
                            <button type="submit" name="download" class="btn p-0 bg-transparent border-0" title="Download">
                                <span class="text-info">⤓</span> <!-- Download icon -->
                            </button>
                        </form>
                    </div>
                </div>
    
                <!-- Body -->
                <div class="body p-3">
                    <table class="table">
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
                            foreach ($filtered_holidays as $index => $holiday): 
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
                                            <span class="text-primary" title="Edit" style="cursor: pointer;" onclick="alert('Edit feature not implemented yet');">✎</span>
                                            <form method="POST" action="" class="d-inline">
                                                <button type="submit" name="delete" value="<?php echo $index; ?>" class="btn p-0 bg-transparent border-0" title="Delete" onclick="return confirm('Are you sure you want to delete this holiday?');">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>