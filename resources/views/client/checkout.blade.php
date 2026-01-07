@extends('client.layout')

@section('content')


<link rel="stylesheet" href="{{asset('css/client/checkout.css')}}">        

<div class="checkout-container">

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

        <!-- PAYMENT -->
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

        <button class="pay-btn" id="payBtn">
            PAY £0.00
        </button>
        <!-- <button class="pay-btn" id="payBtn">
            PAY £{{ number_format($total,2) }}
        </button> -->

    </div>

    <div class="right basket-card">

        <h3 class="basket-title">Your Basket</h3>

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
        @foreach($cart as $index => $item)
            <div class="basket-item" onclick="openQtyPopup({{ $index }})">

                <div class="item-row">
                    <span class="qty">{{ $item['qty'] }}x</span>
                    <span class="item-name">{{ $item['name'] }}</span>
                    <span class="item-price">£{{ number_format($item['total'],2) }}</span>

                    <!-- DELETE ITEM -->
                     <button class="delete-item"
                        onclick="event.stopPropagation(); deleteItem({{ $index }})">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                        <!-- <button class="delete-item" onclick="deleteItem({{ $index }})">
                        <i class="fa-solid fa-trash"></i>
                    </button> -->
                </div>

                @if(!empty($item['modifiers']))
                    <div class="modifier-list">
                        @foreach($item['modifiers'] as $mIndex => $mod)
                            <div class="modifier">
                                + {{ $mod['name'] }}
                                <span>£{{ number_format($mod['price'],2) }}</span>

                                <!-- DELETE MODIFIER -->
                                 <button class="delete-modifier"
                                    onclick="event.stopPropagation(); deleteModifier({{ $index }}, {{ $mIndex }})">
                                    ✕
                                </button>
                                <!-- <button class="delete-modifier"
                                    onclick="deleteModifier({{ $index }}, {{ $mIndex }})">
                                    ✕
                                </button> -->
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        @endforeach

        <div class="bill-details">
            <div class="bill-row">
                <span>Sub Total</span>
                <span id="subTotal">£{{ $total }}</span>
            </div>

            <div class="bill-row">
                <span>Service Charge</span>
                <span id="serviceCharge">£1</span>
            </div>

            <div class="bill-row" id="deliveryChargeRow">
                <span>Delivery Charge</span>
                <span id="deliveryCharge">£2</span>
            </div>

            <hr>

            <div class="bill-row total">
                <span>Total</span>
                <span id="finalTotal">£{{ $total + 1 + 2 }}</span>
            </div>
        </div>

    </div>

</div>



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

        <button class="update-btn" onclick="updateQty()">
            Update
        </button>

        <!-- <button class="close-btn" onclick="closeQtyPopup()">Cancel</button> -->

    </div>
</div>


<script>
    // Check if user is logged in (Laravel session)
    const isLoggedIn = {{ session()->has('customer_id') ? 'true' : 'false' }};
</script>

<!-- ADDRESS MODAL -->
<div class="address-modal" id="addressModal">

    <div class="address-popup">

        <div class="popup-header">
            <h3>Add Address</h3>
            <span class="close-btn" id="closeAddressPopup">&times;</span>
        </div>

        <input type="text" class="address-search" placeholder="Enter postcode" id="postcodeSearch">

        <div class="address-list" id="addressList"></div>

        <div class="manual-address">
            + Add Address Manually...
        </div>

    </div>

</div>



<script src="https://js.stripe.com/v3/"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const payBtn = document.getElementById('payBtn');
        const cart = @json($cart);
        const isLoggedIn = {{ session()->has('customer_id') ? 'true' : 'false' }};

        payBtn.addEventListener('click', async () => {

            if (!isLoggedIn) {
                window.location.href = '{{ route("login") }}?redirect=checkout';
                return;
            }

            const finalTotal = localStorage.getItem('final_total');
            const orderType = document.querySelector('input[name="order_type"]:checked').value;
            const address = document.getElementById('addressText').innerText;

            // 1️⃣ Save data to Laravel session
            await fetch('{{ route("cart.save") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart: cart,
                    final_total: finalTotal,
                    order_type: orderType,
                    delivery_address: address
                })
            });

            // 2️⃣ Create Stripe session
            const res = await fetch('{{ route("stripe.session") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ total: finalTotal })
            });

            const data = await res.json();

            const stripe = Stripe('{{ env("STRIPE_KEY") }}');
            stripe.redirectToCheckout({ sessionId: data.id });
        });

    });
</script>


<!-- <script>

      const isLoggedIn = {{ session()->has('customer_id') ? 'true' : 'false' }};

    payBtn.addEventListener('click', () => {
        if (!isLoggedIn) {
            // Redirect to login with intended page (checkout)
            window.location.href = '{{ route("login") }}?redirect=checkout';
            return;
        }

        // Logged in → proceed to Stripe
        const total = localStorage.getItem('final_total');

        fetch('{{ route("stripe.session") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cart, total })
        })
        .then(res => res.json())
        .then(data => {
            const stripe = Stripe('{{ env("STRIPE_KEY") }}');
            stripe.redirectToCheckout({ sessionId: data.id });
        })
        .catch(err => console.error(err));
    });
    
</script> -->

<script>
    /* ---------------- Delivery / Pickup Toggle ---------------- */
    const deliveryRadio = document.querySelector('input[value="delivery"]');
    const pickupRadio = document.querySelector('input[value="pickup"]');
    const addressTitle = document.getElementById('addressTitle');
    const addressText = document.getElementById('addressText');

    deliveryRadio.addEventListener('change', () => {
        addressTitle.innerText = 'Delivery Address';
        addressText.innerText = 'Delivery Address needed to fulfill the order';
    });

    pickupRadio.addEventListener('change', () => {
        addressTitle.innerText = 'Pickup at';
        addressText.innerText = 'Master Chef';
    });

    /* ---------------- Address Modal ---------------- */
    const modal = document.getElementById('addressModal');
    const openBtn = document.getElementById('openAddressPopup');
    const closeBtn = document.getElementById('closeAddressPopup');
    const addressBox = document.getElementById('addressBox');

    

    openBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    addressBox.addEventListener('click', () => {
        // Only open modal if Delivery is selected
        const deliverySelected = document.querySelector('input[name="order_type"][value="delivery"]').checked;
        if(deliverySelected){
            modal.style.display = 'flex';
        }
    });

    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    /* ---------------- Postcode Autocomplete ---------------- */
    const searchInput = document.getElementById('postcodeSearch');
    const addressList = document.getElementById('addressList');
    let typingTimer;

    searchInput.addEventListener('keyup', function () {
        clearTimeout(typingTimer);
        const postcode = this.value.trim();

        if (postcode.length < 3) {
            addressList.innerHTML = '';
            return;
        }

        typingTimer = setTimeout(() => {
            fetchAddresses(postcode);
        }, 600);
    });

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

                data.result.forEach(pc => {
                    addressList.innerHTML += `
                        <div class="address-item" onclick="fetchFullAddress('${pc}')">
                            <strong>${pc}</strong>
                            <p>United Kingdom</p>
                            <span class="distance">In delivery area</span>
                        </div>
                    `;
                });
            })
            .catch(() => {
                addressList.innerHTML = `<p style="padding:10px;color:red">Error loading addresses</p>`;
            });
    }

    /* ---------------- Fetch Full Address ---------------- */
    function fetchFullAddress(postcode) {
        fetch(`https://api.postcodes.io/postcodes/${postcode}`)
            .then(res => res.json())
            .then(data => {
                if(data.status === 200 && data.result) {
                    const r = data.result;
                    // Construct full address string
                    const fullAddress = `${r.admin_ward}, ${r.parish}, ${r.postcode}`;
                    selectAddress(fullAddress);
                } else {
                    alert('Full address not found');
                }
            })
            .catch(() => {
                alert('Error fetching full address');
            });
    }

    /* ---------------- Select Address ---------------- */
    function selectAddress(fullAddress) {
        // Keep the warning style so it still looks like your styled box
        // Optionally, you can remove it if you want green or normal after selection
        addressText.classList.add('selected-address'); // optional class if you want different style

        // Update the content of the address box
        addressText.innerHTML = `<strong>${fullAddress}</strong>`;

        // Update the search input (optional, useful if user wants to see/edit it)
        searchInput.value = fullAddress;

        // Clear the address list in modal
        addressList.innerHTML = '';

        // Close the modal
        modal.style.display = 'none';
    }



</script>

<script>
    const cart = @json($cart);

    const SERVICE_CHARGE = 1;
    const DELIVERY_CHARGE = 2;

    const subTotalEl = document.getElementById('subTotal');
    const serviceChargeEl = document.getElementById('serviceCharge');
    const deliveryChargeEl = document.getElementById('deliveryCharge');
    const finalTotalEl = document.getElementById('finalTotal');
    const deliveryChargeRow = document.getElementById('deliveryChargeRow');

    /* ---------------- Calculate Cart Total (Items + Modifiers) ---------------- */
    function calculateSubTotal() {
        let subTotal = 0;

        cart.forEach(item => {
            // item total (already qty * base price)
            subTotal += parseFloat(item.total);

            // modifier prices
            if (item.modifiers && item.modifiers.length > 0) {
                item.modifiers.forEach(mod => {
                    subTotal += parseFloat(mod.price);
                });
            }
        });

        return subTotal;
    }

    /* ---------------- Final Total Calculation ---------------- */
    function calculateFinalTotal() {
        const subTotal = calculateSubTotal();

        let total = subTotal + SERVICE_CHARGE;

        if (deliveryChargeRow.style.display !== 'none') {
            total += DELIVERY_CHARGE;
        }
        const formattedTotal = total.toFixed(2);

        subTotalEl.innerText = `£${subTotal.toFixed(2)}`;
        serviceChargeEl.innerText = `£${SERVICE_CHARGE.toFixed(2)}`;
        deliveryChargeEl.innerText = `£${DELIVERY_CHARGE.toFixed(2)}`;
        finalTotalEl.innerText = `£${formattedTotal}`;

            // 🔥 UPDATE PAY BUTTON ALSO
        payBtn.innerText = `PAY £${formattedTotal}`;

        // localStorage.setItem('final_total', formattedTotal);
        localStorage.setItem('final_total', 1.00);
    }

    /* ---------------- Delivery / Pickup Toggle ---------------- */
    function updateOrderType(type) {
        if (type === 'delivery') {
            deliveryChargeRow.style.display = 'flex';
        } else {
            deliveryChargeRow.style.display = 'none';
        }
        calculateFinalTotal();
    }

    /* ---------------- Restore on Refresh ---------------- */
    window.addEventListener('load', () => {
        const savedOrderType = localStorage.getItem('order_type') || 'delivery';
        document.querySelector(`input[name="order_type"][value="${savedOrderType}"]`).checked = true;
        updateOrderType(savedOrderType);

        calculateFinalTotal();
    });

    document.querySelectorAll('input[name="order_type"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            localStorage.setItem('order_type', e.target.value);
            updateOrderType(e.target.value);
        });
    });
</script>

<script>
    function deleteItem(index){
        if(!confirm('Remove this item?')) return;

        fetch('{{ route("cart.item.delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ index })
        })
        .then(res => res.json())
        .then(() => location.reload());
    }

    function deleteModifier(itemIndex, modifierIndex){
        fetch('{{ route("cart.modifier.delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ itemIndex, modifierIndex })
        })
        .then(res => res.json())
        .then(() => location.reload());
    }
</script>

<script>
    let currentIndex = null;
    let currentQty = 1;

   function openQtyPopup(index){
        const item = cart[index];

        currentIndex = index;
        currentQty = item.qty;

        const unitPrice = item.total / item.qty;

        document.getElementById('popupItemName').innerText = item.name;
        document.getElementById('popupItemPrice').innerText =
            `£${unitPrice.toFixed(2)}`;

        document.getElementById('popupQty').innerText = currentQty;

        document.getElementById('qtyModal').style.display = 'flex';
    }

    function closeQtyPopup(){
        document.getElementById('qtyModal').style.display = 'none';
    }

    function changeQty(change){
        currentQty = Math.max(1, currentQty + change);
        document.getElementById('popupQty').innerText = currentQty;
    }

    function updateQty(){
        fetch('{{ route("cart.update.qty") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                index: currentIndex,
                qty: currentQty
            })
        })
        .then(res => res.json())
        .then(() => location.reload());
    }
</script>


<script>

     document.addEventListener('DOMContentLoaded', () => {
        const payBtn = document.getElementById('payBtn');
        const cart = @json($cart);
        const isLoggedIn = {{ session()->has('customer_id') ? 'true' : 'false' }} === true;

        payBtn.addEventListener('click', () => {
            if (!isLoggedIn) {
                // Redirect to login and come back to checkout
                window.location.href = '{{ route("login") }}?redirect=checkout';
                return;
            }

            // User is logged in → proceed to Stripe
            const total = localStorage.getItem('final_total'); 

            fetch('{{ route("stripe.session") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ cart, total })
            })
            .then(res => res.json())
            .then(data => {
                const stripe = Stripe('{{ env("STRIPE_KEY") }}');
                stripe.redirectToCheckout({ sessionId: data.id });
            })
            .catch(err => console.error(err));
        });
    });
    
</script>
@endsection
