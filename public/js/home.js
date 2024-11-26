

// JavaScript to initialize the charts
document.addEventListener("DOMContentLoaded", function () {
    // Initialize Sales Chart (Pie Chart)
    var pieChartCtx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(pieChartCtx, {
        type: 'pie', // Pie chart type
        data: {
            labels: ['Electronics', 'Clothing', 'Groceries'],
            datasets: [{
                data: [300, 50, 100], // Sample data
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
            }]
        },
        options: {
            responsive: true, // Makes the chart responsive
            maintainAspectRatio: false, // Allows resizing based on parent container
        }
    });

    // Initialize Orders Chart (Bar Chart)
    var ordersChartCtx = document.getElementById('ordersChart').getContext('2d');
    var ordersChart = new Chart(ordersChartCtx, {
        type: 'bar', // Bar chart type
        data: {
            labels: ['January', 'February', 'March'],
            datasets: [{
                label: 'Orders',
                data: [65, 59, 80], // Sample data
                backgroundColor: '#4BC0C0',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
});

