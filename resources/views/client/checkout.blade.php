@extends('client.layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/client/checkout.css') }}">

<div class="checkout-container">

    <!-- LEFT COLUMN: Delivery & Payment -->
    <div class="left">

        <!-- BACK -->
        <a href="{{ route('orders') }}" class="back-link">← Back</a>

        <!-- DELIVERY / PICKUP TITLE -->
        <h3 id="addressTitle">Delivery Address</h3>

        <!-- ADDRESS VIEW -->
        <div id="addressBox">
            <p class="warning" id="addressText">
                Delivery Address needed to fulfill the order
            </p>
        </div>

        <!-- PAYMENT OPTIONS -->
        <h3>Payment</h3>
        <div class="payment-options">
            <label class="payment-option">
                <input type="radio" name="payment_type" value="card" checked>
                <span><i class="fa-solid fa-credit-card"></i> Card</span>
            </label>

            <label class="payment-option">
                <input type="radio" name="payment_type" value="cash">
                <span><i class="fa-solid fa-money-bill-wave"></i> Cash</span>
            </label>
        </div>

        <button class="pay-btn" id="payBtn">PAY £0.00</button>

    </div>

    <!-- RIGHT COLUMN: Basket -->
    <div class="right basket-card">
        <h3 class="basket-title">Your Basket</h3>

        <!-- DELIVERY / PICKUP TOGGLE -->
        <div class="delivery-toggle">
            <label class="toggle-option" id="openAddressPopup">
                <input type="radio" name="order_type" value="delivery" checked>
                <span>
                    <i class="fa-solid fa-motorcycle"></i>
                    Delivery
                </span>
            </label>

            <label class="toggle-option">
                <input type="radio" name="order_type" value="pickup">
                <span>
                    <i class="fa-solid fa-store"></i>
                    Pickup
                </span>
            </label>
        </div>

        <!-- BASKET ITEMS -->
        @foreach($cart as $index => $item)
        <div class="basket-item" onclick="openQtyPopup({{ $index }})">
            <div class="item-row">
                <span class="qty">{{ $item['qty'] }}x</span>
                <span class="item-name">{{ $item['name'] }}</span>
                <span class="item-price">£{{ number_format($item['total'], 2) }}</span>

                <button class="delete-item" onclick="event.stopPropagation(); deleteItem({{ $index }})">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>

            @if(!empty($item['modifiers']))
            <div class="modifier-list">
                @foreach($item['modifiers'] as $mIndex => $mod)
                <div class="modifier">
                    + {{ $mod['name'] }}
                    <span>£{{ number_format($mod['price'],2) }}</span>
                    <button class="delete-modifier" onclick="event.stopPropagation(); deleteModifier({{ $index }}, {{ $mIndex }})">
                        ✕
                    </button>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach

        <!-- BILL DETAILS -->
        <div class="bill-details">
            <div class="bill-row">
                <span>Sub Total</span>
                <span id="subTotal">£{{ $total }}</span>
            </div>
            <div class="bill-row">
                <span>Service Charge</span>
                <span id="serviceCharge">£1.00</span>
            </div>
            <div class="bill-row" id="deliveryChargeRow">
                <span>Delivery Charge</span>
                <span id="deliveryCharge">£2.00</span>
            </div>
            <hr>
            <div class="bill-row total">
                <span>Total</span>
                <span id="finalTotal">£{{ $total + 1 + 2 }}</span>
            </div>
        </div>

    </div>

</div>

<!-- QUANTITY MODAL -->
<div class="qty-modal" id="qtyModal">
    <div class="qty-popup">
        <button class="close-icon" onclick="closeQtyPopup()">✕</button>
        <h3 id="popupItemName"></h3>
        <p id="popupItemPrice"></p>
        <div class="qty-controls">
            <button onclick="changeQty(-1)">−</button>
            <span id="popupQty">1</span>
            <button onclick="changeQty(1)">+</button>
        </div>
        <button class="update-btn" onclick="updateQty()">Update</button>
    </div>
</div>

<!-- ADDRESS MODAL -->
<div class="address-modal" id="addressModal">
    <div class="address-popup">
        <div class="popup-header">
            <h3>Add Address</h3>
            <span class="close-btn" id="closeAddressPopup">&times;</span>
        </div>
        <input type="text" class="address-search" placeholder="Enter postcode" id="postcodeSearch">
        <div class="address-list" id="addressList"></div>
        <div class="manual-address">+ Add Address Manually...</div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>

<script>
    const SHOP_LAT = 51.5226;
    const SHOP_LNG = -0.1571;


    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 3958.8; // Miles
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;

        const a =
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI/180) *
            Math.cos(lat2 * Math.PI/180) *
            Math.sin(dLon/2) * Math.sin(dLon/2);

        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const cart = @json($cart);
    const payBtn = document.getElementById('payBtn');
    const addressText = document.getElementById('addressText');
    const addressBox = document.getElementById('addressBox');
    const modal = document.getElementById('addressModal');
    const openBtn = document.getElementById('openAddressPopup');
    const closeBtn = document.getElementById('closeAddressPopup');
    const addressList = document.getElementById('addressList');
    const searchInput = document.getElementById('postcodeSearch');
    const deliveryChargeRow = document.getElementById('deliveryChargeRow');
    const subTotalEl = document.getElementById('subTotal');
    const serviceChargeEl = document.getElementById('serviceCharge');
    const deliveryChargeEl = document.getElementById('deliveryCharge');
    const finalTotalEl = document.getElementById('finalTotal');

    const SERVICE_CHARGE = 1;
    const DELIVERY_CHARGE = 2;

    let currentIndex = null;
    let currentQty = 1;
    const isLoggedIn = {{ session()->has('customer_id') ? 'true' : 'false' }};

    /* ---------------- Delivery / Pickup Toggle ---------------- */

    function updateOrderType(type) {
    if (type === 'delivery') {
        deliveryChargeRow.style.display = 'flex';
        
        // ✅ Restore saved address if exists
        const savedAddress = localStorage.getItem('selected_address');
        if (savedAddress) {
            addressText.classList.add('selected-address');
            addressText.innerHTML = `<strong>${savedAddress}</strong>`;
        } else {
            addressText.classList.remove('selected-address');
            addressText.innerText = 'Delivery Address needed to fulfill the order';
        }

    } else {
        deliveryChargeRow.style.display = 'none';
        
        // ✅ Show In-Store but DON'T delete saved address
        addressText.classList.add('selected-address');
        addressText.innerText = 'In-Store';
    }
    calculateFinalTotal();
}

    // function updateOrderType(type) {
    //      if(type === 'delivery') {
    //             deliveryChargeRow.style.display = 'flex';
    //             addressText.innerText = 'Delivery Address needed to fulfill the order';
    //             addressText.classList.remove('selected-address');
    //         } else {
    //             deliveryChargeRow.style.display = 'none';
    //             addressText.innerText = 'In-Store'; // Pickup address
    //             addressText.classList.add('selected-address');
    //         }
    //         calculateFinalTotal();
    // }

    document.querySelectorAll('input[name="order_type"]').forEach(radio => {
        radio.addEventListener('change', e => {
            localStorage.setItem('order_type', e.target.value);
            updateOrderType(e.target.value);
        });
    });

   window.addEventListener('load', () => {
        const savedOrderType = localStorage.getItem('order_type') || 'delivery';
        document.querySelector(`input[name="order_type"][value="${savedOrderType}"]`).checked = true;
        updateOrderType(savedOrderType);

         const savedAddress = localStorage.getItem('selected_address');
        if (savedAddress) {
            addressText.classList.add('selected-address');
            addressText.innerHTML = `<strong>${savedAddress}</strong>`;
        }s

        calculateFinalTotal();
    });

    addressBox.addEventListener('click', () => {
        const deliverySelected = document.querySelector('input[name="order_type"][value="delivery"]').checked;
        if(deliverySelected) modal.style.display='flex';
    });

    /* ---------------- Calculate Totals ---------------- */
    function calculateSubTotal() {
        let subTotal = 0;
        cart.forEach(item => {
            subTotal += parseFloat(item.total);
            if(item.modifiers) item.modifiers.forEach(mod => subTotal += parseFloat(mod.price));
        });
        return subTotal;
    }

    function calculateFinalTotal() {
        let total = calculateSubTotal() + SERVICE_CHARGE;
        if(deliveryChargeRow.style.display !== 'none') total += DELIVERY_CHARGE;
        const formattedTotal = total.toFixed(2);
        subTotalEl.innerText = `£${calculateSubTotal().toFixed(2)}`;
        serviceChargeEl.innerText = `£${SERVICE_CHARGE.toFixed(2)}`;
        deliveryChargeEl.innerText = `£${DELIVERY_CHARGE.toFixed(2)}`;
        finalTotalEl.innerText = `£${formattedTotal}`;
        payBtn.innerText = `PAY £${formattedTotal}`;
        localStorage.setItem('final_total', formattedTotal);
    }

    /* ---------------- Quantity Modal ---------------- */
    function openQtyPopup(index) {
        const item = cart[index];
        currentIndex = index;
        currentQty = item.qty;
        const unitPrice = item.total / item.qty;
        document.getElementById('popupItemName').innerText = item.name;
        document.getElementById('popupItemPrice').innerText = `£${unitPrice.toFixed(2)}`;
        document.getElementById('popupQty').innerText = currentQty;
        document.getElementById('qtyModal').style.display = 'flex';
    }

    window.openQtyPopup = openQtyPopup;
    window.closeQtyPopup = () => document.getElementById('qtyModal').style.display = 'none';
    window.changeQty = change => {
        currentQty = Math.max(1, currentQty + change);
        document.getElementById('popupQty').innerText = currentQty;
    }
    window.updateQty = () => {
        fetch('{{ route("cart.update.qty") }}', {
            method:'POST',
            headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
            body: JSON.stringify({ index: currentIndex, qty: currentQty })
        }).then(res=>res.json()).then(()=>location.reload());
    }

    /* ---------------- Delete Item/Modifier ---------------- */
    window.deleteItem = index => {
        if(!confirm('Remove this item?')) return;
        fetch('{{ route("cart.item.delete") }}', {
            method:'POST',
            headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
            body: JSON.stringify({ index })
        }).then(res=>res.json()).then(()=>location.reload());
    }

    window.deleteModifier = (itemIndex, modifierIndex) => {
        fetch('{{ route("cart.modifier.delete") }}', {
            method:'POST',
            headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
            body: JSON.stringify({ itemIndex, modifierIndex })
        }).then(res=>res.json()).then(()=>location.reload());
    }

    /* ---------------- Address Modal ---------------- */
    openBtn.addEventListener('click', () => modal.style.display='flex');
    addressBox.addEventListener('click', () => {
        const deliverySelected = document.querySelector('input[name="order_type"][value="delivery"]').checked;
        if(deliverySelected) modal.style.display='flex';
    });
    closeBtn.addEventListener('click', () => modal.style.display='none');
    modal.addEventListener('click', e => { if(e.target === modal) modal.style.display='none'; });

    let typingTimer;
    searchInput.addEventListener('keyup', function(){
        clearTimeout(typingTimer);
        const postcode = this.value.trim();
        if(postcode.length < 3){ addressList.innerHTML=''; return; }
        typingTimer = setTimeout(()=> fetchAddresses(postcode), 600);
    });

    function fetchAddresses(postcode){
        addressList.innerHTML=`<p style="padding:10px">Searching...</p>`;
        fetch(`https://api.postcodes.io/postcodes/${postcode}/autocomplete`)
            .then(res=>res.json())
            .then(data=>{
                addressList.innerHTML='';
                if(!data.result || data.result.length===0){ 
                    addressList.innerHTML=`<p style="padding:10px;color:red">No address found</p>`; return;
                }
                data.result.forEach(pc=>{
                    addressList.innerHTML+=`
                        <div class="address-item" onclick="fetchFullAddress('${pc}')">
                            <strong>${pc}</strong>
                            <p>United Kingdom</p>
                        </div>
                    `;
                });
            }).catch(()=>addressList.innerHTML=`<p style="padding:10px;color:red">Error loading addresses</p>`);
    }

    function fetchAddresses(postcode) {
        addressList.innerHTML = `<p style="padding:10px">Searching...</p>`;

        fetch(`https://api.postcodes.io/postcodes/${postcode}/autocomplete`)
            .then(res => res.json())
            .then(data => {
                addressList.innerHTML = '';

                if (!data.result || data.result.length === 0) {
                    addressList.innerHTML = `<p style="padding:10px;color:red">No address found</p>`;
                    return;
                }

                const limit = parseFloat(localStorage.getItem('selected_mile_value')) || 3;

                data.result.forEach(pc => {

                    fetch(`https://api.postcodes.io/postcodes/${pc}`)
                        .then(res => res.json())
                        .then(fullData => {

                            if (fullData.status === 200) {
                                const r = fullData.result;

                                // Calculate distance
                                const distance = calculateDistance(SHOP_LAT, SHOP_LNG, r.latitude, r.longitude);
                                const rounded = distance.toFixed(2);

                                if (distance <= limit) {
                                    const fullAddress = `${r.admin_ward}, ${r.parish}, ${r.postcode}`;
                                    // Inside → clickable
                                    const div = document.createElement('div');
                                    div.className = 'address-item';
                                    div.style.cssText = 'border-left:5px solid green; padding:10px; cursor:pointer';
                                    div.innerHTML = `<strong style="color:green;">${pc}</strong><p>${rounded} miles - Inside Delivery Area</p>`;
                                    div.addEventListener('click', () => selectAddress(fullAddress));  // ✅ No quote issues
                                    addressList.appendChild(div);
                                } else {
                                    // Outside → not clickable
                                    const div = document.createElement('div');
                                    div.className = 'address-item';
                                    div.style.cssText = 'border-left:5px solid red; padding:10px; opacity:0.6; cursor:not-allowed';
                                    div.innerHTML = `<strong style="color:red;">${pc}</strong><p>${rounded} miles - Outside Delivery Area</p>`;
                                    addressList.appendChild(div);
                                }
                            }

                        });
                });

            })
            .catch(() => {
                addressList.innerHTML = `<p style="padding:10px;color:red">Error loading addresses</p>`;
        });
    }

    // window.fetchFullAddress = postcode=>{
    //     fetch(`https://api.postcodes.io/postcodes/${postcode}`)
    //         .then(res=>res.json())
    //         .then(data=>{
    //             if(data.status===200 && data.result){
    //                 const r = data.result;
    //                 const fullAddress = `${r.admin_ward}, ${r.parish}, ${r.postcode}`;
    //                 selectAddress(fullAddress);
    //             } else alert('Full address not found');
    //         }).catch(()=>alert('Error fetching full address'));
    // }

    function selectAddress(fullAddress){
        addressText.classList.add('selected-address');
        addressText.innerHTML=`<strong>${fullAddress}</strong>`;
        searchInput.value = fullAddress;
        addressList.innerHTML='';
        modal.style.display='none';

        localStorage.setItem('selected_address', fullAddress);
    }

    /* ---------------- Pay Button ---------------- */
    payBtn.addEventListener('click', async () => {
    const orderType = document.querySelector('input[name="order_type"]:checked').value;
    const paymentType = document.querySelector('input[name="payment_type"]:checked').value;

    // Delivery requires an address
    if(orderType === 'delivery' && addressText.innerText.includes('needed')){
        alert('Please select a delivery address!');
        return;
    }

    // Must be logged in
    if(!isLoggedIn){
        window.location.href='{{ route("login") }}?redirect=checkout';
        return;
    }

    const total = localStorage.getItem('final_total');

    // Save cart and order data to session
    await fetch('{{ route("cart.save") }}', {
        method:'POST',
        headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
        body: JSON.stringify({
            cart, 
            final_total: total, 
            order_type: orderType, 
            delivery_address: addressText.innerText,
            payment_type: paymentType
        })
    });

    // ---------------- Payment Handling ----------------
    if(paymentType === 'card'){
        // Card → Stripe
        const res = await fetch('{{ route("stripe.session") }}', {
            method:'POST',
            headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
            body: JSON.stringify({ total })
        });
        const data = await res.json();
        const stripe = Stripe('{{ env("STRIPE_KEY") }}');
        stripe.redirectToCheckout({ sessionId: data.id });
        } else {
        if(paymentType === 'cash') {
                window.location.href = '{{ route("orders.success") }}';
            }
        }
    });

    
    // payBtn.addEventListener('click', async ()=>{
    //     const orderType = document.querySelector('input[name="order_type"]:checked').value;

    //     if(orderType === 'delivery' && addressText.innerText.includes('needed')){
    //         alert('Please select a delivery address!');
    //         return;
    //     }

    //     if(!isLoggedIn){
    //         window.location.href='{{ route("login") }}?redirect=checkout';
    //         return;
    //     }

    //     const total = localStorage.getItem('final_total');

    //     // Save cart and order data to session
    //     await fetch('{{ route("cart.save") }}', {
    //         method:'POST',
    //         headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
    //         body: JSON.stringify({
    //             cart, 
    //             final_total: total, 
    //             order_type: orderType, 
    //             delivery_address: addressText.innerText
    //         })
    //     });

    //     // Stripe payment
    //     const res = await fetch('{{ route("stripe.session") }}', {
    //         method:'POST',
    //         headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}' },
    //         body: JSON.stringify({ total })
    //     });
    //     const data = await res.json();
    //     const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    //     stripe.redirectToCheckout({ sessionId: data.id });
    // });

});
</script>

@endsection
