@extends('client.layout')
@section('content')

    <link rel="stylesheet" href="{{asset('css/client/client-order.css')}}">        

    <div class="container">
        <div class="order-container">
            <div class="image-box">

                <button class="search-btn">
                    <i class="fa fa-search"></i> 
                </button>

                <img src="{{asset('images/client/bg.jpg')}}" class="order-img">

                <div class="white-box">
                    <div class="info-left">
                        <h3 class="title">Master Chef</h3>

                        <!-- <p class="desc">Start your day with us! Fresh, warm and made with love.</p> -->

                        <p class="address">
                            <i class="fa fa-location-dot"></i> 
                            31, Uppukkulam Road, Columbuthurai, Jaffna 40000.
                        </p>

                        <div class="delivery-pickup">
                            <div class="options active"  data-type="delivery">
                                <i class="fa fa-truck"></i>
                                <div class="option">
                                    <div class="title">Delivery</div>                                
                                    <div class="subtitle">Pre-order</div>
                                </div>
                            </div>
                            <div class="options" data-type="pickup">
                                <i class="fa fa-shopping-bag"></i>
                                 <div class="option">
                                    <div class="title">Pickup</div>                                
                                    <div class="subtitle">Pre-order</div>
                                </div>
                            </div>
                        </div>                      
                    </div>
                    <div class="info-right">
                        <div class="review-section">
                            <i class="fa fa-star" style="color: #f7d410ff;"></i> 4.8 (230+ reviews)
                            <a href="#" class="review-link"> <i class="fa fa-circle-info info-icon"></i> Info</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="menu-container">

            <!-- LEFT SIDEBAR: Categories -->
            
            <div class="sidebar">
                <ul>
                    <li class="active" data-target="all-items">All Items</li>
                    @foreach($categories as $category)
                        <li>
                            <!-- <a href="#category-{{ $category->cat_id }}"> -->
                                {{ $category->cat_name }}
                            <!-- </a> -->
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="menu-content">

                <!-- RECOMMENDED SECTION -->
                 <div class="recommended">
                    <h4>👍 RECOMMENDED FOR YOU</h4>
                    <div class="recommended-items">
                        @forelse($recommendedItems as $recItem)
                            <div class="item-box" onclick="openItemPopup({{ $recItem->item_id }})">
                                <strong>{{ $recItem->item_name }}</strong><br>
                                £{{ number_format($recItem->item_price, 2) }}
                            </div>
                        @empty
                            <p style="padding-left: 15px; color: gray; font-size: 0.8rem;">
                                Order more to see personalized suggestions!
                            </p>
                        @endforelse
                    </div>
                </div>
                <!-- <div class="recommended">
                    <h4>👍 RECOMMENDED FOR YOU</h4>
                    <div class="recommended-items">
                        <div class="item-box">apple cake<br>£5.00</div>
                        <div class="item-box">juice<br>£3.50</div>
                        <div class="item-box">Biscoff Milkshake<br>£5.00</div>
                         <div class="item-box">Biscoff Milkshake<br>£5.00</div>
                    </div>
                </div> -->

                <!-- CATEGORY SECTION -->

                @foreach($categories as $category)
                <div class="category-section" id="category-{{ $category->cat_id }}">
                    <!-- CATEGORY NAME -->
                    <h2>{{ $category->cat_name }}</h2>

                    @foreach($category->subCategories as $subCategory)
                        <div class="category-item">

                            <!-- SUB CATEGORY HEADER -->
                            <div class="category-header">
                                <div class="left-title">
                                    {{ $subCategory->sub_cat_name }}
                                </div>

                                <div class="right-image">
                                    <img src="{{ asset($subCategory->image ?? 'images/client/background.jpg') }}" alt="">
                                </div>
                            </div>

                            <!-- SUB CATEGORY DESCRIPTION -->
                            <p>{{ $subCategory->description }}</p>

                            <!-- ITEMS -->
                            <div class="sizes">
                                @foreach($subCategory->items as $item)
                                    <div class="size-box"
                                        onclick="openItemPopup({{ $item->item_id }})"
                                        data-name="{{ $item->item_name }}"
                                        data-price="{{ $item->item_price }}">
                                        <strong>{{ $item->item_name }}</strong><br>
                                        £{{ number_format($item->item_price, 2) }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                @endforeach

               
            </div>
        </div>        
    </div>

    
    <div class="item-popup" id="itemPopup">
        <div class="popup-overlay" onclick="closeItemPopup()"></div>

        <div class="popup-box">
            <!-- HEADER -->
            <button class="close-btn" onclick="closeItemPopup()">&times;</button>

            <div class="popup-header">
                <h3 id="popupItemName"></h3>
                <span class="price">£<span id="popupItemPrice"></span></span>
            </div>

            <!-- MODIFIERS -->
            <div id="modifierContainer"></div>

            <!-- FOOTER -->
            <div class="popup-footer">
                <div class="qty-box">
                    <button onclick="changeQty(-1)">−</button>
                    <span id="qty">1</span>
                    <button onclick="changeQty(1)">+</button>
                </div>

                <!-- <button class="add-btn">
                    ADD £<span id="finalPrice"></span>
                </button> -->
                <button class="add-btn" onclick="addToCart()">
                    <span class="add-text">ADD</span>
                    <span class="add-price">£<span id="finalPrice">0.00</span></span>
                </button>
            </div>
        </div>
    </div>

    <div class="cart-box" id="cartBox" style="display:none;">
        <h4>Your Order</h4>

        <div id="cartItems"></div>

        <div class="cart-footer">
            <strong>Total: £<span id="cartTotal">0.00</span></strong>

            <a href="{{ route('checkout') }}" class="checkout-btn" id="checkoutBtn">
                View Order
            </a>
        </div>
    </div>

<script>
    document.getElementById('checkoutBtn').addEventListener('click', function(e) {
        e.preventDefault();

        const cart = JSON.parse(localStorage.getItem('cart') || '[]');

        const total = document.getElementById('cartTotal').innerText;
        const orderType = document.querySelector('.delivery-pickup .options.active').dataset.type;

        fetch('{{ route("cart.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                cart: cart,
                final_total: total,
                order_type: orderType
            })
        })
        .then(() => {
            window.location.href = '{{ route("checkout") }}';
        });
    });

    // document.getElementById('checkoutBtn').addEventListener('click', function(e) {
    //     e.preventDefault(); // stop normal link

    //     // Get cart from localStorage
    //     const cart = JSON.parse(localStorage.getItem('cart') || '[]');

    //     // Send to server
    //     fetch('{{ route("cart.save") }}', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json',
    //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //         },
    //         body: JSON.stringify({ cart })
    //     })
    //     .then(res => res.json())
    //     .then(data => {
    //         // Now go to checkout page
    //         window.location.href = '{{ route("checkout") }}';
    //     })
    //     .catch(err => console.error(err));
    // });
</script>
<script>
    let cart = [];

    document.addEventListener('DOMContentLoaded', () => {
        const savedCart = localStorage.getItem('cart');
        if(savedCart){
            cart = JSON.parse(savedCart);
            renderCart();
        }
    });
    
    function addToCart() {
        const itemName = document.getElementById('popupItemName').innerText;
        const itemPrice = parseFloat(document.getElementById('popupItemPrice').innerText);

        // Get selected modifiers
        let selectedModifiers = [];
        document.querySelectorAll('#modifierContainer input:checked').forEach(el => {
            selectedModifiers.push({
                name: el.parentElement.innerText.trim(),
                price: parseFloat(el.dataset.price)
            });
        });

        // Calculate final price
        let modifierTotal = selectedModifiers.reduce((sum, mod) => sum + mod.price, 0);
        let finalPrice = (itemPrice + modifierTotal) * qty;

        // Push to cart
        cart.push({
            id: currentItemId,
            name: itemName,
            basePrice: itemPrice,
            qty: qty,
            modifiers: selectedModifiers,
            total: finalPrice
        });

        // Update cart view
        renderCart();

        // Close popup
        closeItemPopup();
    }
    function renderCart() {
        const cartBox = document.getElementById('cartBox');
        const cartItemsContainer = document.getElementById('cartItems');
        const cartTotalEl = document.getElementById('cartTotal');

        cartItemsContainer.innerHTML = ''; // clear previous

         // ❌ cart empty → hide
        if (cart.length === 0) {
            cartBox.style.display = 'none';
            cartTotalEl.innerText = '0.00';
            localStorage.setItem('cart', JSON.stringify(cart));
            return;
        }

        // ✅ cart has items → show
        cartBox.style.display = 'block';

        let total = 0;

        cart.forEach((item, index) => {
            total += item.total;

            cartItemsContainer.innerHTML += `
                <div class="cart-item">
                    <div class="cart-item-main">
                        <span class="qty">${item.qty}x</span>
                        <span class="name">${item.name}</span>
                        <span class="price">£${item.total.toFixed(2)}</span>
                        <button onclick="removeCartItem(${index})" class="remove-btn">×</button>
                    </div>

                    ${
                        item.modifiers.length > 0
                        ? `
                            <div class="cart-modifiers">
                                ${item.modifiers.map(m =>
                                    `<div class="modifier-line">+ ${m.name}</div>`
                                ).join('')}
                            </div>
                        `
                        : ''
                    }
                </div>
            `;
            // let modifiersText = '';
            // if(item.modifiers.length > 0){
            //     modifiersText = `<br><small>Modifiers: ${item.modifiers.map(m => m.name).join(', ')}</small>`;
            // }

            // cartItemsContainer.innerHTML += `
            //     <div class="cart-item">
            //         ${item.qty} x <strong>${item.name}</strong>  £${item.total.toFixed(2)}
            //         ${modifiersText}
            //         <button onclick="removeCartItem(${index})" class="remove-btn">×</button>
            //     </div>
            // `;
        });

        cartTotalEl.innerText = total.toFixed(2);
            localStorage.setItem('cart', JSON.stringify(cart));

    }
    function removeCartItem(index) {
        cart.splice(index, 1);
        localStorage.removeItem('cart');
        renderCart();
    }

</script>
    
<script>
    let basePrice = 0;
    let qty = 1;
    let currentItemId = null;
    function openItemPopup(itemId) {

        currentItemId=itemId;
        fetch(`/client/item/${itemId}`)
            .then(res => res.json())
            .then(data => {

                document.getElementById('itemPopup').style.display = 'block';

                document.getElementById('popupItemName').innerText = data.item_name;
                document.getElementById('popupItemPrice').innerText = data.item_price;

                basePrice = parseFloat(data.item_price);
                qty = 1;
                document.getElementById('qty').innerText = qty;

                let html = '';

                data.modifier_groups.forEach(group => {

                    html += `
                    <div class="modifier-group">
                        <h4>
                            ${group.group_name}
                            <span>${group.max_select > 1 ? '(Optional)' : '(Required)'}</span>
                        </h4>
                    `;

                    group.modifiers.forEach(mod => {

                        let type = group.max_select > 1 ? 'checkbox' : 'radio';

                        html += `
                            <div class="option">
                                <label>
                                    <input type="${type}"
                                        name="group_${group.id}"
                                        data-price="${mod.price}"
                                        onchange="updatePrice()">
                                    ${mod.name}
                                </label>
                                <span>£${mod.price}</span>
                            </div>
                        `;
                    });

                    html += `</div>`;
                });

                document.getElementById('modifierContainer').innerHTML = html;

                updatePrice();
            })
            .catch(err => console.error(err));
    }

    function closeItemPopup() {
        document.getElementById('itemPopup').style.display = 'none';
    }

    function changeQty(val) {
        qty = Math.max(1, qty + val);
        document.getElementById('qty').innerText = qty;
        updatePrice();
    }

    function updatePrice() {

        // 1️⃣ item total = item_price × qty
        let itemTotal = basePrice * qty;

        // 2️⃣ modifier total (NO qty multiply)
        let modifierTotal = 0;

        document.querySelectorAll('#modifierContainer input:checked')
            .forEach(el => {
                modifierTotal += parseFloat(el.dataset.price);
            });

        // 3️⃣ final total
        let finalTotal = itemTotal + modifierTotal;

        document.getElementById('finalPrice').innerText = finalTotal.toFixed(2);
    }
</script>

<script>
    const options = document.querySelectorAll('.delivery-pickup .options');
    options.forEach(option => {
        option.addEventListener('click', () => {

            // remove active from all
            options.forEach(o => o.classList.remove('active'));

            // add active only to clicked one
            option.classList.add('active');

            // optional: check which is selected
            console.log("Selected:", option.dataset.type);
        });
    });
</script>
@endsection



