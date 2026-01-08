@extends('admin.layout')

@section('title','Customers')
@section('page_title','Customers')

@section('content')

<style>
    body {
        background: #f3fdf6;
    }

    /* PAGE HEADER */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-header h3 {
        font-weight: 700;
        color: #1b5e20;
    }

    .total-box {
        background: #4CAF50;
        color: #fff;
        padding: 14px 26px;
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 10px 25px rgba(76,175,80,0.35);
    }

    /* CARD */
    .admin-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 25px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.08);
    }

    /* TABLE */
    .table-custom thead th {
        background: black;
        color: #fff;
        border: none;
        padding: 14px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .table-custom tbody tr {
        transition: all 0.25s ease;
    }

    .table-custom tbody tr:hover {
        background: #e8f5e9;
    }

    .table-custom td {
        padding: 16px;
        border-bottom: 1px solid #c8e6c9;
        vertical-align: middle;
    }

    /* AVATAR */
    .avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #4CAF50;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        box-shadow: 0 5px 12px rgba(76,175,80,.5);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-name {
        font-weight: 600;
        color: #1b5e20;
    }

    .user-email {
        font-size: 13px;
        color: #4e944f;
    }

    /* ID BADGE */
    .id-badge {
        background: #e8f5e9;
        color: #1b5e20;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
    }

    /* DATE */
    .date-pill {
        background: #c8e6c9;
        color: #1b5e20;
        padding: 6px 14px;
        border-radius: 18px;
        font-size: 13px;
        font-weight: 600;
    }

    /* EMPTY */
    .empty-state {
        padding: 60px;
        text-align: center;
        color: #4e944f;
    }

    .empty-state i {
        font-size: 50px;
        margin-bottom: 10px;
        color: #4CAF50;
    }

</style>

<div class="container-fluid">

    

    <!-- CARD -->
    <div class="admin-card">


        <!-- HEADER -->
        <div class="page-header">
            <h3>
                <i class="bi bi-people-fill me-2"></i> Customers
            </h3>

            <div class="total-box">
                Total Customers : {{ $customers->count() }}
            </div>
        </div>

        @if($customers->count())
            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Joined</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($customers as $customer)
                            <tr>
                                <td>
                                    <span class="id-badge">#{{ $customer->id }}</span>
                                </td>

                                <td>
                                    <div class="user-info">
                                        <div class="avatar">
                                            {{ strtoupper(substr($customer->name,0,1)) }}
                                        </div>
                                        <div>
                                            <div class="user-name">{{ $customer->name }}</div>
                                            <div class="user-email">{{ $customer->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <i class="bi bi-envelope-fill me-1" style="color:#4CAF50"></i>
                                    {{ $customer->email }}
                                </td>

                                <td>
                                    <span class="date-pill">
                                        {{ $customer->created_at->format('d M Y') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-person-x"></i>
                <h5>No Customers Found</h5>
                <p>Customers will appear once they register.</p>
            </div>
        @endif

    </div>

</div>

@endsection
