@extends('admin.layout')

@section('title','Dashboard')
@section('page_title','Dashboard')

@section('content')

<style>
    body {
        background: #f8f9fa;
    }

    /* STAT CARDS */
    .stat-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: box-shadow .3s;
        border-left: 4px solid #007bff;
    }

    .stat-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .stat-card.success {
        border-left-color: #28a745;
    }

    .stat-card.danger {
        border-left-color: #dc3545;
    }

    .stat-card.warning {
        border-left-color: #ffc107;
    }

    .stat-card.info {
        border-left-color: #17a2b8;
    }

    .stat-title {
        color: #6c757d;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 600;
        color: #212529;
    }

    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        opacity: 0.8;
    }

    .icon-box.primary {
        background: #e7f1ff;
        color: #007bff;
    }

    .icon-box.success {
        background: #d4edda;
        color: #28a745;
    }

    .icon-box.danger {
        background: #f8d7da;
        color: #dc3545;
    }

    .icon-box.warning {
        background: #fff3cd;
        color: #ffc107;
    }

    .icon-box.info {
        background: #d1ecf1;
        color: #17a2b8;
    }

    /* TABLE CARD */
    .table-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .table-card h5 {
        font-weight: 600;
        color: #212529;
        margin-bottom: 20px;
        font-size: 18px;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: #f8f9fa;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
        padding: 12px;
        font-size: 14px;
        font-weight: 600;
    }

    .table tbody tr {
        border-bottom: 1px solid #f1f3f5;
    }

    .table tbody tr:last-child {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .table td {
        padding: 14px 12px;
        vertical-align: middle;
        color: #495057;
        font-size: 14px;
    }

    /* STATUS BADGES */
    .status-badge {
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }

    .status-badge.completed {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .status-badge.new {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-badge.pending {
        background: #fff3cd;
        color: #856404;
    }
</style>

<div class="container-fluid">

    <!-- STATS ROW -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-title">Total Orders</div>
                        <div class="stat-value">{{ $totalOrders }}</div>
                    </div>
                    <div class="icon-box primary">
                        <i class="bi bi-cart"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-title">Completed Orders</div>
                        <div class="stat-value">{{ $completedOrders }}</div>
                    </div>
                    <div class="icon-box success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card danger">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-title">Cancelled Orders</div>
                        <div class="stat-value">{{ $cancelledOrders }}</div>
                    </div>
                    <div class="icon-box danger">
                        <i class="bi bi-x-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-title">Total Customers</div>
                        <div class="stat-value">{{ $totalCustomers }}</div>
                    </div>
                    <div class="icon-box info">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- REVENUE & RATING ROW -->
    <div class="row g-3 mb-4">

        <div class="col-md-6">
            <div class="stat-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-title">Today Revenue</div>
                        <div class="stat-value">£{{ number_format($todayRevenue, 2) }}</div>
                    </div>
                    <div class="icon-box warning">
                        <i class="bi bi-currency-pound"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="stat-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-title">Average Rating</div>
                        <div class="stat-value">{{ number_format($avgRating, 1) }} <i class="bi bi-star-fill" style="color: #ffc107; font-size: 20px;"></i></div>
                    </div>
                    <div class="icon-box warning">
                        <i class="bi bi-star"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- RECENT ORDERS TABLE -->
    <div class="table-card">
        <h5>
            <i class="bi bi-clock-history text-primary me-2"></i>Recent Orders
        </h5>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->customer_id }}</td>
                        <td><strong>£{{ number_format($order->total_amount, 2) }}</strong></td>
                        <td>
                            <span class="status-badge {{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection