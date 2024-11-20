// Set default font settings
Chart.defaults.global.defaultFontFamily = '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById("myAreaChart");
    var chartData = JSON.parse(chartData);

    console.log("Months:", chartData.months);
    console.log("Expense Totals:", chartData.totals);

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
                    // Set a reasonable max value based on your data
                    max: Math.max(...expenseTotals) * 1.2,
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
});
