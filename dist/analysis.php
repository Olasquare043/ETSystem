<?php
session_start();
include('connection.php');
include('databank.php');
$user_id = $_SESSION['user_id'];
$user_details = getUserDetails($db, $user_id);
include('header.php');
?>

<div class="container">
    <h2 class="text-center mt-4">Expense Analysis</h2>
    <div class="row">
        <div class="col-md-6">
            <canvas id="myBarChart1"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="myPieChart1"></canvas>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    $.ajax({
        url: 'expenseAnalysis.php',
        type: 'GET',
        success: function(data) {
            const chartData = JSON.parse(data);

            // Bar Chart
            var ctxBar = document.getElementById("myBarChart1");
            var myBarChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: chartData.categories.labels,
                    datasets: [{
                        label: "Total Expenses by Category",
                        backgroundColor: "rgba(2,117,216,1)",
                        borderColor: "rgba(2,117,216,1)",
                        data: chartData.categories.data,
                    }],
                },
                options: {
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                autoSkip: false
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            gridLines: {
                                display: true
                            }
                        }],
                    },
                    legend: {
                        display: true
                    }
                }
            });

            // Pie Chart
            var ctxPie = document.getElementById("myPieChart1");
            var myPieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: chartData.months.labels,
                    datasets: [{
                        label: "Total Expenses by Month",
                        backgroundColor: [
                            "rgba(2,117,216,1)",
                            "rgba(255, 99, 132, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(75, 192, 192, 1)",
                            "rgba(153, 102, 255, 1)",
                            "rgba(255, 159, 64, 1)"
                        ],
                        data: chartData.months.data,
                    }],
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Total Expenses by Month'
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        },
        error: function() {
            alert('Error fetching expense analysis data.');
        }
    });
});
</script>

<?php
include('footer.php');
?>
