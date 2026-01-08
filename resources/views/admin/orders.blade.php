@extends('admin.layout')

@section('title','Orders')
@section('page_title','Orders')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="{{asset('css/admin/admin-order.css')}}">        

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
            <li onclick="updateStatus('on_the_way')">On the Way</li>
            <li onclick="updateStatus('completed')">Completed</li>
            <li onclick="updateStatus('cancelled')">Cancel</li>
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

    </div>

    <!-- RIGHT COLUMN -->
    <div class="orders-list-col">
        <div class="status-tabs">
            <button class="active" onclick="filterStatus(this, 'new')">CURRENT</button>
            <button onclick="filterStatus(this, 'on_the_way')">ON THE WAY</button>
            <button onclick="filterStatus(this, 'completed')">COMPLETED</button>
            <button onclick="filterStatus(this, 'cancelled')">CANCELLED</button>
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
                @foreach($orders as $order)
                <tr onclick="loadOrder({{ $order->id }})"
                    data-status="{{ $order->status }}">
                    
                    <td>{{ $order->id }}</td>

                    <td>
                        {{ $order->order_type == 'delivery' ? '🚚' : '🏠' }}
                    </td>

                    <td>
                        {{ $order->order_type == 'pickup' ? 'Instore' : $order->delivery_address }}
                    </td>

                    <td>{{ $order->created_at->format('H:i') }}</td>

                    <td>£{{ number_format($order->total_amount, 2) }}</td>

                    <td>
                        {{ $order->payment_type == 'card' ? '💳' : '💵' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
    let selectedOrderId = null;

    function loadOrder(orderId) {
        selectedOrderId = orderId;

        fetch(`/admin/orders/${orderId}`)
            .then(res => res.json())
            .then(data => {

                document.getElementById('orderID').querySelector('strong').innerText = data.id;
                document.getElementById('orderType').querySelector('strong').innerText = data.order_type.toUpperCase();
                document.getElementById('orderTime').querySelector('strong').innerText =
                    new Date(data.created_at).toLocaleTimeString();
                document.getElementById('paymentType').innerText =
                    data.payment_type.toUpperCase();

                const itemsDiv = document.getElementById('orderItems');
                itemsDiv.innerHTML = '';

                // Header row
                itemsDiv.innerHTML += `
                    <div class="order-item header">
                        <span class="name">Item</span>
                        <span class="qty">Qty</span>
                        <span class="unit">Unit</span>
                        <span class="total">Total</span>
                    </div>
                    <hr>
                `;

                let subtotal = 0;

                data.items.forEach(item => {
                    const unitPrice = parseFloat(item.unit_price).toFixed(2);
                    const totalPrice = parseFloat(item.total_price).toFixed(2);

                    itemsDiv.innerHTML += `
                        <div class="order-item">
                            <span class="name">${item.item_name}</span>
                            <span class="qty">${item.quantity}</span>
                            <span class="unit">£${unitPrice}</span>
                            <span class="total">£${totalPrice}</span>
                        </div>
                    `;
                    subtotal += parseFloat(item.total_price);
                });

                // Totals row — align everything in right column
                itemsDiv.innerHTML += `<hr>`;
                itemsDiv.innerHTML += `
                    <div class="order-summary">
                        <div class="summary-row"><span>Subtotal:</span> <span>£${subtotal.toFixed(2)}</span></div>
                        <div class="summary-row"><span>Delivery:</span> <span>£${parseFloat(data.delivery_charge).toFixed(2)}</span></div>
                        <div class="summary-row"><span>Service:</span> <span>£${parseFloat(data.service_charge).toFixed(2)}</span></div>
                        <div class="summary-row"><span><strong>Grand Total:</strong></span> <span><strong>£${parseFloat(data.total_amount).toFixed(2)}</strong></span></div>
                        <div class="summary-row"><span>Payment:</span> <span>${data.payment_type.toUpperCase()}</span></div>
                    </div>
                `;
        });
    }
    function updateStatus(status) {
        if (!selectedOrderId) {
            alert('Please select an order');
            return;
        }

        fetch(`/admin/orders/${selectedOrderId}/status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status })
        })
        .then(res => res.json())
        .then(() => {
            alert('Order status updated');
            location.reload();
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // CURRENT button select pannum
        const defaultBtn = document.querySelector('.status-tabs button.active');

        // Page open aagum pothu filter run
        filterStatus(defaultBtn, 'new');

    });
    function filterStatus(btn, status) {

        // active button
        document.querySelectorAll('.status-tabs button')
            .forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // filter rows
        document.querySelectorAll('#ordersTable tbody tr')
            .forEach(row => {
                row.style.display =
                    row.dataset.status === status ? 'table-row' : 'none';
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

<script>
function printOrder() {

    if (!selectedOrderId) {
        alert('Please select an order to print');
        return;
    }

    const printContent = document.getElementById('orderDetailsCol').innerHTML;

    const printWindow = window.open('', '', 'width=900,height=600');

    printWindow.document.write(`
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    padding: 20px;
                    max-width: 400px;
                    margin: auto;
                }
                h3 {
                    text-align: center;
                    margin: 2px 0;
                }
                h4 {
                    text-align: center;
                    margin-bottom: 10px;
                }
                .menu-container {
                    display: none; /* hide menu */
                }
                #orderItems {
                    font-family: monospace;
                    margin-top: 10px;
                }
                .order-item {
                    display: flex;
                    justify-content: space-between;
                    padding: 2px 0;
                }
                .order-item.header {
                    font-weight: bold;
                }
                .order-item span {
                    flex: 1;
                    text-align: left;
                }
                .order-item .qty,
                .order-item .unit,
                .order-item .total {
                    flex: 0.8;
                    text-align: right;
                }
                .order-summary {
                    margin-top: 10px;
                    font-weight: bold;
                    border-top: 1px dashed #000;
                    padding-top: 5px;
                }
                .summary-row {
                    display: flex;
                    justify-content: space-between;
                    padding: 2px 0;
                }
                .payment-type {
                    display: block;
                    margin-top: 10px;
                    text-align: right;
                }
            </style>
        </head>
        <body>
            <!-- Shop Header -->
            <h3>Master Chef</h3>
            <h3>15 Baker Street, <br>London, W1U 3BW, <br>United Kingdom</h3>
            <h3>+44 7700 900123</h3>
            <hr>

            <!-- Order Content -->
            ${printContent}
        </body>
        </html>
    `);

    printWindow.document.close();

    printWindow.focus();
    printWindow.print();
}
</script>
@endsection
