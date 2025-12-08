@extends('client.layout')
@section('content')

    <link rel="stylesheet" href="{{asset('css/client-order.css')}}">        

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
                            <div class="options">
                                <i class="fa fa-truck"></i>
                                <div class="option">
                                    <div class="title">Delivery</div>                                
                                    <div class="subtitle">Pre-order</div>
                                </div>
                            </div>
                            <div class="options">
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
                    <li class="active">All Items</li>
                    <li>Pizzas</li>
                    <li>Garlic Bread</li>
                    <li>USA Burgers</li>
                    <li>USA Chicken Kebab</li>
                    <li>USA Wraps And Dippers</li>
                    <li>Extras</li>
                    <li>Kids Meals With Capri Sun</li>
                    <li>Meal Deals</li>
                    <li>Desserts</li>
                    <li>Drinks</li>
                    <li>USA Rice bowl</li>
                </ul>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="menu-content">

                <!-- RECOMMENDED SECTION -->
                <div class="recommended">
                    <h4>👍 RECOMMENDED FOR YOU</h4>
                    <div class="recommended-items">
                        <div class="item-box">apple cake<br>£5.00</div>
                        <div class="item-box">juice<br>£3.50</div>
                        <div class="item-box">Biscoff Milkshake<br>£5.00</div>
                        <div class="item-box">Oreo Milkshake<br>£5.00</div>
                        <div class="item-box">Bowl of Rice<br>£2.00</div>
                    </div>
                </div>

                <!-- CATEGORY SECTION -->
                <div class="category-section">
                    <h2>Pizzas</h2>
                    <div class="category-item">
                        <div class="category-header">
                            <div class="left-title">Margherita</div>
                            <div class="right-image">
                                <img src="{{ asset('images/client/background.jpg') }}" alt="category image">
                            </div>
                        </div> 
                        <p>Margherita</p>

                        <div class="sizes">
                            <div class="size-box"><strong>7" Margherita</strong><br>£7.00</div>
                            <div class="size-box"><strong>10" Margherita</strong><br>£8.40</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        
    </div>
@endsection