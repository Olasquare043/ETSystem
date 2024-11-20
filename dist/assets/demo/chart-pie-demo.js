// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: <?php echo $category_labels_json; ?>, // Use the JSON-encoded PHP variable
        datasets: [{
            data: <?php echo $category_expenses_json; ?>, // Use the JSON-encoded PHP variable
            backgroundColor: [
                'rgba(2,117,216,1)',
                'rgba(255,99,132,1)',
                'rgba(75,192,192,1)',
                'rgba(255,206,86,1)',
                'rgba(153,102,255,1)',
                'rgba(255,159,64,1)',
                'rgba(54,162,235,1)',
            ],
            hoverBackgroundColor: [
                'rgba(2,117,216,0.8)',
                'rgba(255,99,132,0.8)',
                'rgba(75,192,192,0.8)',
                'rgba(255,206,86,0.8)',
                'rgba(153,102,255,0.8)',
                'rgba(255,159,64,0.8)',
                'rgba(54,162,235,0.8)',
            ],
        }],
    },
    options: {
        responsive: true,
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'Expense Distribution by Category'
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    }
});
