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

        <label class="payment-option active">
            <input type="radio" name="payment_type" value="card" checked>
            <span><i class="fa-solid fa-credit-card"></i> Card</span>
        </label>

        <label class="payment-option">
            <input type="radio" name="payment_type" value="cash">
            <span><i class="fa-solid fa-money-bill-wave"></i> Cash</span>
        </label>

    </div>

        
        <button class="pay-btn" id="payBtn">
            PAY £{{ number_format($total,2) }}
        </button>

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

        @foreach($cart as $item)
            <div class="basket-item">

                <div class="item-row">
                    <span class="qty">{{ $item['qty'] }}x</span>
                    <span class="item-name">{{ $item['name'] }}</span>
                    <span class="item-price">£{{ number_format($item['total'],2) }}</span>
                </div>

                @if(!empty($item['modifiers']))
                    <div class="modifier-list">
                        @foreach($item['modifiers'] as $mod)
                            <div class="modifier">
                                + {{ $mod['name'] }}
                                <span>£{{ number_format($mod['price'],2) }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        @endforeach

        <div class="bill-details">
            <div class="bill-row">
                <span>Sub Total</span>
                <span>£10</span>
            </div>

            <div class="bill-row">
                <span>Service Charge</span>
                <span>£20</span>
            </div>

            <div class="bill-row">
                <span>Delivery Charge</span>
                <span>£30</span>
            </div>

            <hr>

            <div class="bill-row total">
                <span>Total</span>
                <span>£20</span>
            </div>
        </div>

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

        <div class="manual-address">
            + Add Address Manually...
        </div>

    </div>

</div>



<script src="https://js.stripe.com/v3/"></script>

<script>
    const payBtn = document.getElementById('payBtn');

    payBtn.addEventListener('click', () => {
        const cart = @json($cart); // your PHP cart
        const total = {{ $total }}; // total in £

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
            return stripe.redirectToCheckout({ sessionId: data.id });
        })
        .then(result => {
            if(result.error){
                alert(result.error.message);
            }
        })
        .catch(err => console.error(err));
    });
</script>

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

@endsection
