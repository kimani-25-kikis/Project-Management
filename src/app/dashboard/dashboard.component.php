<?php
// Start session to access stored projects (if linked to previous form)
session_start();

// Sample data (replace with real data or database queries)
$earnings = 20125; // Could calculate from project prices
$new_clients = 129; // Could track unique clients
$projects = isset($_SESSION['projects']) ? count($_SESSION['projects']) : 154; // From previous form or static
$employees = 650; // Static or from a database

// Simulate report download (optional)
if (isset($_POST['download'])) {
    // In a real app, generate a file (e.g., CSV) and force download
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="employee_salary_report.txt"');
    echo "Sample Employee Salary Report\nGenerated on " . date('Y-m-d');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Assume CSS is linked externally -->
    <link rel="stylesheet" href="styles.css"> <!-- Adjust path as needed -->
    <!-- Chart.js for canvas charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div>
        <div class="nav">
            <h3>Dashboard</h3>
            <h3 class="breadcrumb">🏠 Home > Dashboard</h3>
        </div>
        
        <div class="dashboard">
            <!-- Chart Section -->
            <div class="chart">
                <div class="stat-card">
                    <h3>Project Survey</h3>
                    <canvas id="chartCanvas"></canvas>
                </div>
            </div>

            <!-- Cards Section -->
            <div class="cards">
                <div class="stats">
                    <div class="stat-card">
                        <h3>Earning</h3>
                        <p>$<?php echo number_format($earnings); ?></p>
                        <canvas id="earningsChart"></canvas> 
                    </div>
                    <div class="stat-card">
                        <h3>New Clients</h3>
                        <p><?php echo $new_clients; ?></p>
                        <canvas id="clientsChart"></canvas> 
                    </div>
                    <div class="stat-card">
                        <h3>Projects</h3>
                        <p><?php echo $projects; ?></p>
                        <canvas id="projectsChart"></canvas> 
                    </div>
                    <div class="stat-card">
                        <h3>Employees</h3>
                        <p><?php echo $employees; ?></p>
                        <canvas id="employeesChart"></canvas> 
                    </div>
                </div>
                
                <!-- Download Reports Card -->
                <div class="stat-card download-card">
                    <img src="download_reports.png" alt="Download Reports Icon"/>
                    <div class="download_text">
                        <p>Download Reports</p>
                        <p>Download employee salary reports.</p>
                        <form method="POST" action="">
                            <button type="submit" name="download">
                                <span>Download</span>
                                <!-- Replace mat-icon with an image or text since PHP doesn't handle Angular Material -->
                                <span>↓</span> <!-- Simple fallback for icon -->
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for charts (example, adjust as needed) -->
    <script>
        // Project Survey Chart
        const ctx = document.getElementById('chartCanvas').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['IT', 'Hospitality', 'Engineering', 'Construction'],
                datasets: [{
                    label: 'Projects by Department',
                    data: [<?php echo $projects / 4; ?>, <?php echo $projects / 4; ?>, <?php echo $projects / 4; ?>, <?php echo $projects / 4; ?>], // Placeholder
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            }
        });

        // Earnings Chart (example)
        const earningsCtx = document.getElementById('earningsChart').getContext('2d');
        new Chart(earningsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar'],
                datasets: [{
                    label: 'Earnings',
                    data: [<?php echo $earnings / 3; ?>, <?php echo $earnings / 2; ?>, <?php echo $earnings; ?>],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        });

        // Add similar scripts for clientsChart, projectsChart, employeesChart as needed
    </script>
</body>
</html>