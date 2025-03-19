<?php
// Start session to access stored projects (if linked to previous form)
session_start();

// Sample data (replace with database queries in a real app)
$earnings = 20125;
$new_clients = 129;
$projects = isset($_SESSION['projects']) ? count($_SESSION['projects']) : 0; // From previous form
$total_income = 117289;
$total_expense = 65984;
$country_sales = [
    'India' => 154,
    'USA' => 423,
    'Sri Lanka' => 265,
    'Australia' => 341,
    'Japan' => 238,
    'Italy' => 153
];
$invoices = [
    ['#IN7865', 'John Doe', '12/05/2016', 'Paid', 500],
    ['#IN7867', 'Abdikadir Hausa', '12/06/2016', 'Not paid', 200],
    ['#IN7861', 'Hassan M', '12/01/2016', 'Cancelled', 400]
];
$avg_daily_bill = 129;

// Handle report download
if (isset($_POST['download'])) {
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="employee_salary_report.txt"');
    echo "Employee Salary Report\nGenerated on " . date('Y-m-d') . "\nSample data only.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Assume custom CSS exists -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div>
        <div class="nav">
            <h3>Dashboard</h3>
            <h3 class="breadcrumb">🏠 Home > Dashboard2</h3>
        </div>
        
        <div class="dashboard">
            <!-- Chart Section -->
            <div class="chart mt-3">
                <div class="stat-card">
                    <h3>Project Survey</h3>
                    <canvas id="chartCanvas"></canvas>
                </div>
            </div>

            <!-- Cards Section -->
            <div class="cards mt-3">
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
                </div>
                
                <!-- Download Reports Card -->
                <div class="stat-card download-card">
                    <img src="download_reports.png" alt="Download Reports Icon"/>
                    <div class="download_text">
                        <p>Download Reports</p>
                        <p>Download employee salary reports.</p>
                        <form method="POST" action="">
                            <button type="submit" name="download" class="btn btn-primary d-flex align-items-center">
                                <span class="me-2">Download</span>
                                <span>↓</span> <!-- Replaced mat-icon -->
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Report Card -->
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between">
                    <p>Product Report</p>
                    <div class="dropdown">
                        <span class="dropdown-toggle" data-bs-toggle="dropdown">⋮</span> <!-- Replaced mat-icon -->
                        <ul class="dropdown-menu">
                            <li>Refresh reports</li>
                        </ul>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <!-- First column -->
                        <div class="col-12 col-md-3 p-3">
                            <p class="fs-3">$<?php echo number_format($total_income); ?></p>
                            <p class="text-success fs-4">Total Income</p>
                            <p class="fs-6 pb-3">This is the total income from the projects done.</p>
                            <p class="fs-3">$<?php echo number_format($total_expense); ?></p>
                            <p class="text-warning fs-4">Total Expense</p>
                            <p class="fs-6 pb-3">This is the total expenses incurred from the projects done.</p>
                        </div>
                        <!-- Second column -->
                        <div class="col-12 col-md-5 p-3">
                            <p class="fs-5 fw-bold">Country Wise Sales</p>
                            <?php foreach ($country_sales as $country => $sales): ?>
                                <div class="d-flex align-items-center">
                                    <span class="me-3"><?php echo $country; ?></span>
                                    <div class="progress flex-grow-1 me-3" style="height: 5px;">
                                        <div class="progress-bar <?php echo $country === 'USA' ? 'bg-success' : ($country === 'Sri Lanka' ? 'bg-info' : ($country === 'Australia' ? 'bg-warning' : ($country === 'Japan' ? 'bg-danger' : ($country === 'Italy' ? 'bg-secondary' : '')))); ?>" style="width: <?php echo ($sales / max($country_sales)) * 100; ?>%;"></div>
                                    </div>
                                    <span class="fw-bold"><?php echo $sales; ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Third column -->
                        <div class="col-12 col-md-4 p-3">
                            <div style="width: 200px; height: 200px; margin: auto;">
                                <canvas id="doughnutChart"></canvas>
                            </div>
                            <div class="mt-2">
                                <table class="table table-borderless">
                                    <tbody id="chartLegend">
                                        <!-- Populated by JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices and Daily Bill -->
        <div class="row">
            <div class="card mt-3 mx-4 col-12 col-md-7">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                        <p>Invoices</p>
                        <div class="dropdown">
                            <span class="dropdown-toggle" data-bs-toggle="dropdown">⋮</span>
                            <ul class="dropdown-menu">
                                <li>Refresh table</li>
                            </ul>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice No</th>
                                <th>Client Name</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoices as $invoice): ?>
                                <tr>
                                    <td class="text-primary"><?php echo htmlspecialchars($invoice[0]); ?></td>
                                    <td><?php echo htmlspecialchars($invoice[1]); ?></td>
                                    <td class="text-secondary"><?php echo htmlspecialchars($invoice[2]); ?></td>
                                    <td><span class="badge <?php echo $invoice[3] === 'Paid' ? 'bg-success' : ($invoice[3] === 'Not paid' ? 'bg-secondary' : 'bg-danger'); ?>"><?php echo htmlspecialchars($invoice[3]); ?></span></td>
                                    <td>$<?php echo number_format($invoice[4]); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-3 col-12 col-md-4 p-3">
                <div class="card-body">
                    Average Daily Bill
                    <p class="h3"><?php echo $avg_daily_bill; ?> Dollars<span class="text-secondary fs-6">(Average)</span></p>
                    <div>
                        <canvas id="dolarCanvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Charts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Project Survey Chart
        new Chart(document.getElementById('chartCanvas').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Projects'],
                datasets: [{
                    label: 'Count',
                    data: [<?php echo $projects; ?>],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)'
                }]
            }
        });

        // Earnings Chart
        new Chart(document.getElementById('earningsChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Start', 'End'],
                datasets: [{
                    label: 'Earnings',
                    data: [0, <?php echo $earnings; ?>],
                    borderColor: 'rgb(75, 192, 192)'
                }]
            }
        });

        // Clients Chart
        new Chart(document.getElementById('clientsChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Clients'],
                datasets: [{
                    label: 'New Clients',
                    data: [<?php echo $new_clients; ?>],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)'
                }]
            }
        });

        // Doughnut Chart
        const doughnutChart = new Chart(document.getElementById('doughnutChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_keys($country_sales)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($country_sales)); ?>,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                }
            }
        });
        const legend = document.getElementById('chartLegend');
        doughnutChart.data.labels.forEach((label, i) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td><span style="display:inline-block;width:10px;height:10px;background-color:${doughnutChart.data.datasets[0].backgroundColor[i]}"></span> ${label}</td><td>${doughnutChart.data.datasets[0].data[i]}</td>`;
            legend.appendChild(tr);
        });

        // Dollar Canvas
        new Chart(document.getElementById('dolarCanvas').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Day 1', 'Day 2', 'Day 3'],
                datasets: [{
                    label: 'Daily Bill',
                    data: [<?php echo $avg_daily_bill - 10; ?>, <?php echo $avg_daily_bill; ?>, <?php echo $avg_daily_bill + 10; ?>],
                    borderColor: 'rgb(255, 99, 132)'
                }]
            }
        });
    </script>
</body>
</html>