<?php
session_start();
if (isset($_SESSION['user_id'])) {
    include('connection.php');
    include('databank.php');
    $user_id = $_SESSION['user_id'];
    $user_details = getUserDetails($db, $user_id);
    $incomes = $incomes = getAllIncomes($db, $user_id);
    // Fetch user expenses
    $expenses = getExpenses($db, $user_id);
    include('header.php');
    // Fetch monthly expenses data for the area chart
    $monthlyExpenses = getMonthlyExpenses($db, $user_id);
    $months = [];
    $totals = [];

    foreach ($monthlyExpenses as $expense) {
        $months[] = date("F", mktime(0, 0, 0, $expense['month'], 1));
        $totals[] = $expense['total'];
    }

    $json_data = json_encode([
        'months' => $months,
        'totals' => $totals
    ]);

    $category_data = getExpensesByCategory($db, $user_id);
    $category_labels_json = json_encode($category_data['labels']);
    $category_expenses_json = json_encode($category_data['data']);

    ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var chartData = <?php echo $json_data; ?>;
        var categoryLabels = <?php echo $category_labels_json; ?>;
        var categoryExpenses = <?php echo $category_expenses_json; ?>;

        document.addEventListener('DOMContentLoaded', function () {
            // Area Chart
            var ctx = document.getElementById("myAreaChart");
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.months,
                    datasets: [{
                        label: "Total Expenses",
                        data: chartData.totals,
                        lineTension: 0.3,
                        backgroundColor: "rgba(2,117,216,0.2)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(2,117,216,1)",
                        pointHitRadius: 50,
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'month'
                            },
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                maxTicksLimit: 12
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: Math.max(...chartData.totals) * 1.2,
                                maxTicksLimit: 6
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, .125)",
                            }
                        }],
                    },
                    legend: {
                        display: true
                    }
                }
            });

            // Bar Chart
            var ctxBar = document.getElementById("myBarChart");
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        label: "Expenses by Category",
                        data: categoryExpenses,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    </script>
    <div class="container-fluid px-4">
        <h4 class="mt-4"><?php echo "Welcome " . strtoupper($user_details['username']) ?></h4>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"> Dashboard </li>
        </ol>
        <!-- Charts -->
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Monthly expense area chart
                    </div>
                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Expenses by Categories Chart
                    </div>
                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var chartData = <?php echo $json_data; ?>;
        var categoryLabels = <?php echo $category_labels_json; ?>;
        var categoryExpenses = <?php echo $category_expenses_json; ?>;

        document.addEventListener('DOMContentLoaded', function () {
            // Area Chart
            var ctx = document.getElementById("myAreaChart");
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.months,
                    datasets: [{
                        label: "Total Expenses",
                        data: chartData.totals,
                        lineTension: 0.3,
                        backgroundColor: "rgba(2,117,216,0.2)",
                        borderColor: "rgba(2,117,216,1)",
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(2,117,216,1)",
                        pointBorderColor: "rgba(255,255,255,0.8)",
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(2,117,216,1)",
                        pointHitRadius: 50,
                        pointBorderWidth: 2,
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'month'
                            },
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                maxTicksLimit: 12
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: Math.max(...chartData.totals) * 1.2,
                                maxTicksLimit: 6
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, .125)",
                            }
                        }],
                    },
                    legend: {
                        display: true
                    }
                }
            });

            // Bar Chart
            var ctxBar = document.getElementById("myBarChart");
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        label: "Expenses by Category",
                        data: categoryExpenses,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    </script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('datatablesSimple1');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });
    </script>
    <?php
}
include('footer.php');
?>