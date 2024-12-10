@extends('Staff.layouts.staff')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Dashboard Cards -->
    <div class="dashboard row justify-content-center">
        <!-- Total Orders Card -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card p-4 text-center shadow-lg rounded-3 card-hover bg-light border-primary">
                <i class="fas fa-shopping-cart fa-3x mb-3 text-primary"></i>
                <h3 class="text-primary">Total Orders</h3>
                <p id="totalOrders" class="fs-4 fw-bold">
                    {{ $totalOrders > 0 ? $totalOrders : 'No orders yet' }}
                </p>
            </div>
        </div>

        <!-- Daily Sales Card -->
        <div class="col-lg-4 col-md-6 col-sm-12 ">
            <div class="card p-4 text-center shadow-lg rounded-3 card-hover bg-light border-success">
                <i class="fas fa-dollar-sign fa-3x mb-3 text-success"></i>
                <h3 class="text-success">Daily Sales</h3>
                <p id="dailySales" class="fs-4 fw-bold">
                    {{ $dailySales > 0 ? '$' . number_format($dailySales, 2) : 'No sales yet' }}
                </p>
            </div>
        </div>

        <!-- Add any other cards as necessary -->
    </div>

    <!-- Charts Section -->
    <div class="row mb-5">
        <div class="col-lg-6 col-md-12 mb-3">
            <div class="card p-4 shadow-lg rounded-3 bg-light">
                <h3 class="text-primary">Sales Overview</h3>
                <div class="chart-container" style="position: relative; height:50vh; width:100%;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 mb-3">
            <div class="card p-4 shadow-lg rounded-3 bg-light">
                <h3 class="text-success">Traffic Overview</h3>
                <div class="chart-container" style="position: relative; height:50vh; width:100%;">
                    <canvas id="trafficChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Levels with Modal -->
    <div class="card p-4 shadow-lg rounded-3 bg-light">
        <h3 class="text-danger">Stock Levels</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-danger">
                    <tr>
                        <th>Category</th>
                        <th>Products</th>
                        <th>Stock Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockLevels as $item)
                    <tr class="@if($item->products_count < 50) table-danger @elseif($item->products_count < 150) table-warning @else table-success @endif">
                        <td>{{ $item->category_name }}</td>
                        <td>{{ $item->products_count }}</td>
                        <td>
                            <span class="d-flex align-items-center justify-content-center pointer" data-bs-toggle="modal" data-bs-target="#stockModal{{$item->id}}">
                                <i class="fas @if($item->products_count < 50) fa-times-circle text-danger @elseif($item->products_count < 150) fa-exclamation-circle text-warning @else fa-check-circle text-success @endif me-2"></i>
                                {{ $item->products_count }}
                            </span>
                        </td>
                    </tr>

                    <!-- Modal for stock details -->
                    <div class="modal fade" id="stockModal{{$item->id}}" tabindex="-1" aria-labelledby="stockModalLabel{{$item->id}}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="stockModalLabel{{$item->id}}">Stock Details: {{ $item->category_name }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between p-3 border rounded shadow-sm" style="background-color: #f9f9f9;">
                                        <p><strong class="text-primary">Category:</strong> <span class="text-secondary">{{ $item->category_name }}</span></p>
                                        <p><strong class="text-success">Total Products:</strong> <span class="text-dark">{{ $item->products_count }}</span></p>
                                        <p>
                                            <strong class="text-danger">Low Stock Warning:</strong>
                                            <span class="@if($item->products_count < 50) text-danger @elseif($item->products_count < 150) text-warning @else text-success @endif">
                                                @if($item->products_count < 50) Yes @else No @endif
                                                    </span>
                                        </p>
                                    </div>
                                    <hr>
                                    <h5>Product Details</h5>
                                    @if($item->products->isNotEmpty())
                                    <ul class="list-group">
                                        <!-- Headings Row (Displayed Only Once) -->
                                        <li class="list-group-item">
                                            <div class="d-flex flex-column flex-sm-row align-items-start mb-2">
                                                <span class="flex-fill"><strong>Avatar</strong></span>
                                                <span class="flex-fill"><strong>Name</strong></span>
                                                <span class="flex-fill"><strong>Description</strong></span>
                                                <span class="flex-fill"><strong>Price</strong></span>
                                                <span class="flex-fill"><strong>Status</strong></span>
                                                <span class="flex-fill"><strong>Quantity</strong></span>
                                            </div>
                                        </li>

                                        <!-- Products Loop -->
                                        @foreach ($item->products as $product)
                                        <li class="list-group-item">
                                            <div class="d-flex flex-column flex-sm-row align-items-start mb-2">
                                                <span class="flex-fill">
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; border-radius: 50%;">
                                                </span>
                                                <span class="flex-fill">{{ $product->name }}</span>
                                                <span class="flex-fill">{{ $product->description }}</span>
                                                <span class="flex-fill">${{ number_format($product->price, 2) }}</span>
                                                <span class="flex-fill">
                                                    <span class="badge @if($product->is_active) bg-success @else bg-danger @endif">
                                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </span>
                                                <span class="flex-fill">
                                                    <span class="@if($product->qty < 50) text-danger @elseif($product->qty < 150) text-warning @else text-success @endif">
                                                        {{ $product->qty }}
                                                    </span>
                                                </span>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>

                                    @else
                                    <p>No products available for this category.</p>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@php
$months = $salesData->pluck('month');
$totals = $salesData->pluck('total_sales');
@endphp

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Sales Chart Initialization
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Sales ($)',
                    data: @json($totals),
                    borderColor: '#4caf50',
                    backgroundColor: 'rgba(76, 175, 80, 0.2)',
                    fill: true,
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Traffic Chart Initialization
        const trafficCtx = document.getElementById('trafficChart').getContext('2d');
        new Chart(trafficCtx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Traffic (Visits)',
                    data: [200, 300, 400, 500, 600, 700, 800],
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1,
                }],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

@endsection