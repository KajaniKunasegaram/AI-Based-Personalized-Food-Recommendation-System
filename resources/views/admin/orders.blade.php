@extends('admin.layout')

@section('title','Orders')
@section('page_title','Orders')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f5f6fa;
    color: #333;
}

.orders-dashboard {
    display: flex;
    gap: 20px;
    padding: 15px 0;
}

/* LEFT COLUMN: Order details */
.order-details-col {
    width: 42%;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    padding: 20px;
    display: flex;
    flex-direction: column;
}

.order-details-col h4 {
    font-size: 20px;
    margin-bottom: 15px;
    border-bottom: 1px solid #eee;
    padding-bottom: 8px;
}

.order-meta p {
    margin: 5px 0;
    font-size: 14px;
}

.order-meta strong {
    font-weight: 600;
}

.order-items {
    margin-top: 15px;
    flex: 1;
    overflow-y: auto;
}

.order-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.order-summary {
    margin-top: 15px;
    font-weight: 600;
    border-top: 1px solid #eee;
    padding-top: 10px;
}

.payment-type {
    display: inline-block;
    padding: 3px 8px;
    background: #28a745;
    color: #fff;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    margin-left: 8px;
}

/* STATUS BUTTONS FOR LEFT COLUMN */
.status-update {
    margin-top: 10px;
    display: flex;
    gap: 10px;
}

.status-update button {
    flex: 1;
    padding: 6px 0;
    border: none;
    border-radius: 4px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    color: #fff;
}

.status-update .new { background: #17a2b8; }
.status-update .way { background: #ffc107; color: #333; }
.status-update .completed { background: #28a745; }
.status-update .cancelled { background: #dc3545; }

.status-update button:hover {
    opacity: 0.85;
}

/* RIGHT COLUMN: Orders list */
.orders-list-col {
    width: 58%;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    padding: 10px;
}

.status-tabs {
    display: flex;
    gap: 5px;
    margin-bottom: 10px;
}

.status-tabs button {
    flex: 1;
    padding: 10px 0;
    border: none;
    background: #f0f0f0;
    cursor: pointer;
    font-weight: 600;
    border-radius: 6px 6px 0 0;
    transition: all 0.2s;
}

.status-tabs button.active {
    background: #666;
    color: #fff;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.orders-table th, .orders-table td {
    border: 1px solid #ddd;
    padding: 8px 10px;
    text-align: left;
}

.orders-table th {
    background: #f7f7f7;
    font-weight: 600;
}

.orders-table tr:hover {
    background: #f1f7ff;
    cursor: pointer;
}

.orders-table tr.selected {
    background: #d0e7ff !important;
}

.red-text {
    color: #dc3545;
    font-weight: 600;
}












.menu-container {
    position: relative;
}

.menu-icon {
    position: absolute;
    top: 4px;   /* adjust vertical position */
    right: 6px; /* right side */
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    user-select: none;
}

.menu-dropdown {
    display: none;
    position: absolute;
    top: 24px; /* below the icon */
    right: 0;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    list-style: none;
    padding: 0;
    margin: 0;
    width: 140px;
    z-index: 100;
}

.menu-dropdown li {
    padding: 10px 12px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.2s;
}

.menu-dropdown li:hover {
    background: #f2f2f2;
}

</style>

<div class="orders-dashboard">

    <!-- LEFT COLUMN -->
    <div class="order-details-col" id="orderDetailsCol">

        <!-- <div class="Status-update">
            <td>
                <i class="fa-solid fa-utensils"></i>
                <i class="fa-solid fa-truck"></i>
            </td>
        </div> -->

        <div class="menu-container">
            <span class="menu-icon" onclick="toggleMenu(event)">⋮</span>
            <ul class="menu-dropdown">
            <li onclick="printOrder()">Print</li>
            <li onclick="updateStatus(this, 'on the way')">On the Way</li>
            <li onclick="updateStatus(this, 'completed')">Completed</li>
            <li onclick="updateStatus(this, 'cancelled')">Cancel</li>
            </ul>
        </div>
        
        <h4>Order Details</h4>
        <div class="order-meta">
            <p id="orderType">Type: <strong>---</strong></p>
            <p id="orderID">Order ID: <strong>---</strong></p>
            <p id="orderTime">Time: <strong>---</strong></p>
        </div>

        <div class="order-items" id="orderItems">
            <!-- items go here -->
        </div>

        <div class="order-summary">
            Subtotal: £<span id="orderSubtotal">0.00</span><br>
            Grand Total: £<span id="orderTotal">0.00</span>
            <span class="payment-type" id="paymentType">---</span>
        </div>

        <!-- <div class="status-update">
            <button class="new">New</button>
            <button class="way">On The Way</button>
            <button class="completed">Completed</button>
            <button class="cancelled">Cancelled</button>
        </div> -->
    </div>

    <!-- RIGHT COLUMN -->
    <div class="orders-list-col">
        <div class="status-tabs">
            <button class="active" onclick="filterStatus('current')">CURRENT</button>
            <button onclick="filterStatus('way')">ON THE WAY</button>
            <button onclick="filterStatus('completed')">COMPLETED</button>
            <button onclick="filterStatus('completed')">CANCELLED</button>

        </div>

        <table class="orders-table" id="ordersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Address</th>
                    <th>Time</th>
                    <th>Amt</th>
                    <th>Mode</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example rows -->
                <tr data-status="current" onclick="selectOrder(this)" data-order='{"id":2,"type":"In-Store","address":"Instore","time":"11:09","amt":"70.00","mode":"Cash","items":[{"name":"defswa","qty":7,"price":70}]}'>
                    <td>2</td>
                    <td>🏠</td>
                    <td>Instore</td>
                    <td>11:09</td>
                    <td>£70.00</td>
                    <td>💵</td>
                </tr>
                <tr data-status="completed" onclick="selectOrder(this)" data-order='{"id":7,"type":"Delivery","address":"Home","time":"08:03","amt":"0.12","mode":"Cash","items":[{"name":"item2","qty":1,"price":0.12}]}'>
                    <td class="red-text">7</td>
                    <td>🚚</td>
                    <td class="red-text">Home</td>
                    <td>08:03</td>
                    <td>£0.12</td>
                    <td>💵</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<script>
function filterStatus(status){
    const buttons = document.querySelectorAll('.status-tabs button');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');

    const rows = document.querySelectorAll('#ordersTable tbody tr');
    rows.forEach(row => {
        row.style.display = (row.dataset.status === status) ? 'table-row' : 'none';
    });
}

function selectOrder(row){
    document.querySelectorAll('#ordersTable tbody tr').forEach(r => r.classList.remove('selected'));
    row.classList.add('selected');

    const data = JSON.parse(row.dataset.order);

    document.getElementById('orderID').querySelector('strong').innerText = data.id;
    document.getElementById('orderType').querySelector('strong').innerText = data.type;
    document.getElementById('orderTime').querySelector('strong').innerText = data.time;

    const itemsDiv = document.getElementById('orderItems');
    itemsDiv.innerHTML = '';
    let subtotal = 0;
    data.items.forEach(item => {
        itemsDiv.innerHTML += `<div class="order-item">${item.qty} × ${item.name} £${item.price}</div>`;
        subtotal += item.price;
    });

    document.getElementById('orderSubtotal').innerText = subtotal.toFixed(2);
    document.getElementById('orderTotal').innerText = data.amt;
    document.getElementById('paymentType').innerText = data.mode.toUpperCase();
}


function toggleMenu(e) {
    e.stopPropagation(); // prevent row click
        const dropdown = e.target.nextElementSibling;
        // Hide any other open dropdowns
        document.querySelectorAll('.menu-dropdown').forEach(d => {
            if(d !== dropdown) d.style.display = 'none';
        });
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    // Close dropdown if click outside
    document.addEventListener('click', () => {
        document.querySelectorAll('.menu-dropdown').forEach(d => d.style.display = 'none');
    });
</script>

@endsection
