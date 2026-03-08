<html>
    <head>
        <meta charset="UTF-8">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <title>{{ $title ?? 'Master Chef' }}</title>

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <!-- Basic CSS -->
        <style>
            *{
                font-family: 'Outfit', sans-serif;
                box-sizing: border-box;
            }

            body { 
                margin:0; 
                font-family: Arial, sans-serif; 
                background:#f8f8f8; 
                overflow-x:none;
                overflow-y:none;
            }
        
            /* Header */
            .header {
                /* width:100%; */
                background:black;
                padding:5px 30px;
                display:flex;
                justify-content:space-between;
                align-items:center;
                box-shadow:0 2px 5px rgba(0,0,0,0.1);
                position:sticky;
                top:0;
                height:60px;
                z-index:100;
            }

            .logo img {
                width: 45px;
                height: 45px;
                border-radius: 50%;     /* ⭕ makes it circular */
                object-fit: cover;      /* keep perfect circle, no stretching */
                border: 2px solid #ddd; /* optional outline */
            }

            .nav-items a {
                margin-left:25px;
                text-decoration:none;
                font-size:16px;
                color:#333;
                font-weight:500;
                color:white;
            }

            .nav-items a i {
                margin-right:6px;
            }

            .nav-items a:hover {
                /* color:#cc0000; */
                color:gray;
            }

            /* Body area */
            /* Scrollable body */
            .content {
                position:absolute;
                top:60px;       /* height of header */
                bottom:0;       /* to bottom of page */
                left:0;
                right:0;
                overflow-y:auto;
            }

            /* Footer (not fixed) */

            .footer {
                background: #1a1a2e;
                color: #ccc;
                margin-top: 10px;
            }

            .footer-content {
                display: flex;
                justify-content: space-between;
                gap: 40px;
                padding: 50px 60px;
                flex-wrap: wrap;
            }

            /* Brand */
            .footer-brand h3 {
                color: #fff;
                font-size: 1.4rem;
                margin-bottom: 10px;
            }

            .footer-brand p {
                font-size: 0.85rem;
                line-height: 1.7;
                color: #aaa;
                margin-bottom: 16px;
            }

            .footer-social {
                display: flex;
                gap: 12px;
            }

            .footer-social a {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: rgba(255,255,255,0.08);
                display: flex;
                align-items: center;
                justify-content: center;
                color: #ccc;
                text-decoration: none;
                transition: background 0.2s, color 0.2s;
            }

            .footer-social a:hover {
                background: #e84c3d;
                color: #fff;
            }

            /* Links */
            .footer-links h4,
            .footer-contact h4 {
                color: #fff;
                font-size: 1rem;
                margin-bottom: 16px;
                padding-bottom: 8px;
                border-bottom: 2px solid #e84c3d;
                display: inline-block;
            }

            .footer-links ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .footer-links ul li {
                margin-bottom: 10px;
            }

            .footer-links ul li a {
                color: #aaa;
                text-decoration: none;
                font-size: 0.88rem;
                transition: color 0.2s;
            }

            .footer-links ul li a i {
                font-size: 0.7rem;
                margin-right: 6px;
                color: #e84c3d;
            }

            .footer-links ul li a:hover {
                color: #e84c3d;
                padding-left: 4px;
            }

            /* Contact */
            .footer-contact p {
                font-size: 0.88rem;
                color: #aaa;
                margin-bottom: 12px;
                line-height: 1.6;
            }

            .footer-contact p i {
                color: #e84c3d;
                margin-right: 8px;
                width: 14px;
            }

            /* Bottom bar */
            .footer-bottom {
                border-top: 1px solid rgba(255,255,255,0.08);
                text-align: center;
                padding: 18px;
                font-size: 0.82rem;
                color: #777;
            }

            .footer-bottom strong {
                color: #e84c3d;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .footer-content {
                    flex-direction: column;
                    padding: 30px;
                    gap: 30px;
                }
            }
            /* .footer {
                background:white;
                padding:15px;
                text-align:center;
                border-top:1px solid #ddd;
                margin-top:20px;
            } */
        </style>
    </head>

    <body>

        <!-- HEADER -->
        <div class="header">
            <div class="logo">
                <img src="/images/logo.png" alt="Logo">
            </div>
            <div class="nav-items">
                <a href="{{route('orders')}}"><i class="fa-solid fa-cart-shopping"></i> Order</a>
                <a href="/about"><i class="fa-solid fa-circle-info"></i> About</a>
                <a href="{{ route('client.contact') }}"><i class="fa-solid fa-phone"></i> Contact</a>
                <a href="{{ route('reviews') }}"><i class="fa-solid fa-star"></i> Review</a>
                <a href="{{ route('more') }}"><i class="fa-solid fa-ellipsis"></i> More</a>
            </div>
        </div>

        <!-- BODY -->
        <div class="content">
            @yield('content')

                <!-- FOOTER -->
                 <div class="footer">
    <div class="footer-content">

        <!-- LEFT: Brand -->
        <div class="footer-brand">
            <h3><i class="fa fa-utensils"></i> Master Chef</h3>
            <p>Fresh, warm and made with love.<br>Experience the taste of perfection.</p>
            <div class="footer-social">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>

        <!-- MIDDLE: Quick Links -->
        <div class="footer-links">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ route('orders') }}"><i class="fa fa-chevron-right"></i> Order Now</a></li>
                <li><a href="{{ route('reviews') }}"><i class="fa fa-chevron-right"></i> Reviews</a></li>
                <li><a href="/about"><i class="fa fa-chevron-right"></i> About Us</a></li>
                <li><a href="{{ route('client.contact') }}"><i class="fa fa-chevron-right"></i> Contact</a></li>
                <li><a href="{{ route('more') }}"><i class="fa fa-chevron-right"></i> More</a></li>
            </ul>
        </div>

        <!-- RIGHT: Contact Info -->
        <div class="footer-contact">
            <h4>Contact Us</h4>
            <p><i class="fa fa-location-dot"></i> 15 Baker Street, London
            <br>&nbsp;&nbsp;&nbsp;&nbsp;
W1U 3BW, United Kingdom</p>
            <p><i class="fa fa-phone"></i> +94 21 000 0000</p>
            <p><i class="fa fa-envelope"></i> info@masterchef.lk</p>
            <p><i class="fa fa-clock"></i> Mon - Sun: 8:00 AM – 10:00 PM</p>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© {{ date('Y') }} <strong>Master Chef</strong>. All Rights Reserved. Made with <i class="fa fa-heart" style="color:#e74c3c;"></i> in Jaffna.</p>
    </div>
</div>

            <!-- <div class="footer">
                © {{ date('Y') }} All Rights Reserved.
            </div> -->
        </div>



    </body>
</html>
