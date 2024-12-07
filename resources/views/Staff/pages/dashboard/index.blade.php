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
                <p id="totalOrders">{{ $totalOrders }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h3>Daily Sales</h3>
                <p id="dailySales">${{ number_format($dailySales, 2) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h3>Stock Levels</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Products</th>
                            <th>Stock Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stockLevels as $item)
                        <tr class="@if($item->products_count < 50) text-danger @elseif($item->products_count < 150) text-warning @else text-success @endif">
                            <td>{{ $item->category_name }}</td>
                            <td>{{ $item->products_count  }}</td>
                            <td>
                                <!-- Stock level with color coding -->
                                <span class="d-flex align-items-center">
                                    <i class="fas @if($item->products_count  < 50) fa-times-circle text-danger @elseif($item->products_count  < 150) fa-exclamation-circle text-warning @else fa-check-circle text-success @endif me-2"></i>
                                    {{ $item->products_count  }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the dynamic data from the controller
        const totalOrders = @json($totalOrders);
        const dailySales = @json($dailySales);
        const stockLevels = @json($stockLevels);

        // Set data to the dashboard cards
        document.getElementById('totalOrders').innerText = totalOrders;
        document.getElementById('dailySales').innerText = `$${dailySales.toFixed(2)}`;
        document.getElementById('stockLevels').innerText = stockLevels;

        // Sales data from the controller for the last 6 months
        const salesData = @json($salesData); // Sales data for the chart
        const salesMonths = salesData.map(item => item.month); // Extract months
        const salesAmounts = salesData.map(item => item.total_sales); // Extract total sales

        // Initialize Sales Chart (Line chart)
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: salesMonths, // Dynamic months from the data
                datasets: [{
                    label: 'Sales ($)',
                    data: salesAmounts, // Dynamic sales amounts
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

        // Traffic Chart (Bar chart) - Static data, can be replaced with dynamic data
        const trafficCtx = document.getElementById('trafficChart').getContext('2d');
        const trafficChart = new Chart(trafficCtx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], // Days of the week
                datasets: [{
                    label: 'Traffic (Visits)',
                    data: [200, 250, 300, 400, 500, 600, 550], // Sample traffic data
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
    });
</script>
@endpush