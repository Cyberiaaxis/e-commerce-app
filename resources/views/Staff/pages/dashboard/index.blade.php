@extends('Staff.layouts.staff')

@section('title', 'Dashboard')

@section('content')
<div class="table-container col">
    <h1>Welcome to the App</h1>

    <!-- Dashboard Cards -->
    <div class="dashboard row mb-4">
        <div class="col-md-4">
            <div class="card">
                <h3>Total Orders</h3>
                <p id="totalOrders">0</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h3>Daily Sales</h3>
                <p id="dailySales">$0</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h3>Stock Levels</h3>
                <p id="stockLevels">0</p>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h3>Sales Overview</h3>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Traffic Chart -->
        <div class="col-md-6">
            <h3>Traffic Overview</h3>
            <div class="chart-container">
                <canvas id="trafficChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <h2>Users</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td>
                    <button class="btn btn-warning">Edit</button>
                    <button class="btn btn-danger">Delete</button>
                </td>
            </tr>
            <!-- Add more rows here -->
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sample Data (replace with dynamic data from your backend or API)
    const totalOrders = 1500;
    const dailySales = 3200;
    const stockLevels = 120;

    document.getElementById('totalOrders').innerText = totalOrders;
    document.getElementById('dailySales').innerText = `$${dailySales}`;
    document.getElementById('stockLevels').innerText = stockLevels;

    // Sales Chart (Line chart)
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], // months
            datasets: [{
                label: 'Sales ($)',
                data: [3000, 4000, 3500, 4200, 5000, 4600],
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
            }],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        }
    });

    // Traffic Chart (Bar chart)
    const trafficCtx = document.getElementById('trafficChart').getContext('2d');
    const trafficChart = new Chart(trafficCtx, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], // days of the week
            datasets: [{
                label: 'Traffic (Visits)',
                data: [200, 250, 300, 400, 500, 600, 550],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1,
            }],
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        }
    });
</script>
@endpush