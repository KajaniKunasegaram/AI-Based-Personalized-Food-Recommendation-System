<html>
    <head>
        <meta charset="UTF-8">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <title>{{ $title ?? 'Master Chef' }}</title>

        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <!-- Basic CSS -->
        <style>
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
                background:white;
                padding:15px;
                text-align:center;
                border-top:1px solid #ddd;
                margin-top:20px;
            }
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
                © {{ date('Y') }} All Rights Reserved.
            </div>
        </div>



    </body>
</html>
