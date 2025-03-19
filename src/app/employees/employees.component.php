<?php
// Start session (optional, if linking to previous data)
session_start();

// Sample employee data (replace with database query in a real app)
$employees = [
    [
        'name' => 'John Doe',
        'role' => 'Developer',
        'department' => 'Software Development',
        'mobile' => '+25432270830',
        'joining_date' => '04/10/2019',
        'email' => 'Micheal@gmail.com', // Likely a typo; should be an email like 'nicholas@embuni.ac.ke'
        'gender' => 'Male',
        'address' => '123 Nairobi Kenya'
    ]
    // Add more employees as needed
];

// Handle download action
if (isset($_POST['download'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="employees.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Name', 'Role', 'Department', 'Mobile', 'Joining Date', 'Email', 'Gender', 'Address']);
    foreach ($employees as $employee) {
        fputcsv($output, $employee);
    }
    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Employees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Assume custom CSS exists -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div>
        <p>All Employee</p>

        <div class="card">
            <div>
                <!-- Header -->
                <div class="head bg-light d-flex flex-row justify-content-between align-items-center p-3">
                    <!-- Title & Search -->
                    <div class="d-flex flex-row align-items-center gap-2">
                        <p class="mb-0 fw-bold">Employees</p>
                        <form method="GET" action="" class="d-flex">
                            <input type="text" class="form-control" placeholder="Search..." id="employee" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"/>
                        </form>
                    </div>
    
                    <!-- Icons (basic functionality) -->
                    <div class="d-flex gap-5">
                        <span class="text-primary" title="Filter" style="cursor: pointer;">&#9776;</span> <!-- Filter icon -->
                        <span class="text-success" title="Add Employee" style="cursor: pointer;" onclick="alert('Add employee feature not implemented yet');">&#10010;</span> <!-- Add icon -->
                        <span class="text-secondary" title="Refresh" style="cursor: pointer;" onclick="window.location.reload();">&#10227;</span> <!-- Refresh icon -->
                        <form method="POST" action="" class="d-inline">
                            <button type="submit" name="download" class="btn p-0 bg-transparent border-0" title="Download">
                                <span class="text-info">&#10515;</span> <!-- Download icon -->
                            </button>
                        </form>
                    </div>
                </div>
    
                <!-- Body -->
                <div class="body p-3">
                    <table class="table">
                        <thead>
                            <tr class="fw-bold">
                                <th>Name</th>
                                <th>Role</th>
                                <th>Department</th>
                                <th>Mobile</th>
                                <th>Joining Date</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $filtered_employees = $employees;
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $search = strtolower($_GET['search']);
                                $filtered_employees = array_filter($employees, function($employee) use ($search) {
                                    return strpos(strtolower($employee['name']), $search) !== false ||
                                           strpos(strtolower($employee['role']), $search) !== false ||
                                           strpos(strtolower($employee['department']), $search) !== false;
                                });
                            }
                            foreach ($filtered_employees as $employee): 
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($employee['name']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['role']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['department']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['mobile']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['joining_date']); ?></td>
                                    <td><?php echo htmlspecialchars($employee['email']); ?></td>
                                    <td><span class="badge bg-success fs-6"><?php echo htmlspecialchars($employee['gender']); ?></ 
   
span></td>
                                    <td><?php echo htmlspecialchars($employee['address']); ?></td>
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