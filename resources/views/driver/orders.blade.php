

<style>
/* Page base */
body {
    font-family: 'Inter', 'Segoe UI', sans-serif;
    background: #f2f4f8;
    margin: 0;
    padding: 25px;
    color: #2b2f38;
}

/* Header */
.driver-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #ffffff;
    padding: 18px 24px;
    border-radius: 14px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.06);
    margin-bottom: 25px;
}

.driver-top h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.logout-btn {
    text-decoration: none;
    padding: 8px 14px;
    background: #111827;
    color: #fff;
    border-radius: 8px;
    font-size: 13px;
    transition: 0.3s;
}

.logout-btn:hover {
    background: #374151;
}

/* Table wrapper */
.table-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 18px 40px rgba(0,0,0,0.06);
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

thead {
    background: #f8fafc;
}

thead th {
    padding: 14px 12px;
    text-align: left;
    font-weight: 600;
    color: #6b7280;
    border-bottom: 1px solid #e5e7eb;
}

tbody td {
    padding: 14px 12px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

/* Row hover */
tbody tr:hover {
    background: #f9fafb;
}

/* Status badge */
.status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.status.pending {
    background: #fff7ed;
    color: #c2410c;
}

.status.completed {
    background: #ecfeff;
    color: #0e7490;
}

.status.cancelled {
    background: #fef2f2;
    color: #b91c1c;
}

/* Action form */
.action-form {
    display: flex;
    gap: 8px;
}

.action-form select {
    padding: 6px 10px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    font-size: 13px;
    outline: none;
}

.action-form button {
    padding: 6px 14px;
    border-radius: 8px;
    border: none;
    background: #111827;
    color: #fff;
    font-size: 13px;
    cursor: pointer;
    transition: 0.3s;
}

.action-form button:hover {
    background: #374151;
}

/* Done text */
.done {
    color: #10b981;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 900px) {
    table {
        font-size: 13px;
    }
}
</style>



<div class="driver-top">
    <h2>Welcome, {{ session('driver_name') }}</h2>
    <a href="{{ url('/driver/logout') }}" class="logout-btn">Logout</a>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Address</th>
                <th>Time</th>
                <th>Amount</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="ordersBody">
        @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ ucfirst($order->order_type) }}</td>
                <td>{{ $order->order_type == 'pickup' ? 'Instore' : $order->delivery_address }}</td>
                <td>{{ $order->created_at->format('H:i') }}</td>
                <td>£{{ number_format($order->total_amount,2) }}</td>
                <td>{{ strtoupper($order->payment_type) }}</td>

                <td>
                    <span class="status {{ $order->status }}">
                        {{ strtoupper($order->status) }}
                    </span>
                </td>

                <td>
                    @if($order->status != 'completed' && $order->status != 'cancelled')
                        <form method="POST"
                              action="{{ url('/driver/orders/'.$order->id.'/status') }}"
                              class="action-form">
                            @csrf
                            <select name="status">
                                 <option value="on_the_way">On the way</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    @else
                        <span class="done">✔ Done</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<!-- 
<script>
function loadOrders() {
    fetch('/driver/orders/json')
        .then(res => res.json())
        .then(data => {
            let html = '';

            data.forEach(order => {
                html += `
                <tr>
                    <td>${order.id}</td>
                    <td>${order.order_type}</td>
                    <td>${order.order_type === 'pickup' ? 'Instore' : order.delivery_address}</td>
                    <td>${order.created_at}</td>
                    <td>£${order.total_amount}</td>
                    <td>${order.payment_type.toUpperCase()}</td>
                    <td>${order.status.toUpperCase()}</td>
                    <td>
                        ${order.status !== 'completed' && order.status !== 'cancelled'
                        ? `
                        <form method="POST" action="/driver/orders/${order.id}/status">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <select name="status">
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>`
                        : '✔ Done'}
                    </td>
                </tr>`;
            });

            document.getElementById('ordersBody').innerHTML = html;
        });
}

// First load
loadOrders();

// Every 1 second update (NO reload)
setInterval(loadOrders, 1000);
</script> -->

<!-- <script>
    // 1 second = 1000 milliseconds
    setInterval(function () {
        location.reload();
    }, 1000);
</script> -->