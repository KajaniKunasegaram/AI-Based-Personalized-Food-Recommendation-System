<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
        <title>Admin - @yield('title')</title>

        <style>
            * {
                font-family: "Times New Roman", Times, serif;
                overflow-x:none;
                overflow-y:none;
            }
            .topbar{
                height:60px;
                background:#D6D6D6;
                display:flex;
                align-items:center;
                justify-content:space-between;
                padding:0 10px;
                position: fixed;

                top: 0;
                left: 0;
                width: 100%;
                z-index: 999;
            }

            .left-section {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            
            .right-section {
                display: flex;
                gap: 10px;
            }

            .main {
                padding: 8px 16px;
                border: 1px solid #1D8556;
                background: transparent;
                color: #1D8556;
                border-radius: 6px;
                cursor: pointer;
                font-size: 14px;
            }

            .main:hover {
                background: #1D8556;
                color:white;
            }

            

            .menu {
                background: transparent !important;
                color: black;
                border: none;
                font-size: 24px;
                cursor: pointer;
            }

            .menu:hover {
                background: transparent !important;
            }
           
           .offcanvas {
                position: fixed;
                top: 0;
                right: -350px;     
                width: 350px;
                height: 100vh;
                background-color: #F5F5F5;
                box-shadow: -2px 0px 10px rgba(0,0,0,0.2);
                transition: right 0.3s ease-in-out;
                z-index: 9999;
            }
            .offcanvas.show {
                right: 0;         
            }

            .restaurant-info {
                display: flex;
                align-items: center;
                padding: 15px;
                border-bottom: 1px solid #eee;
            }

            .restaurant-logo {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                overflow: hidden;
                margin-right: 12px;
                background-color: #f9f9f9;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                /* border :3px solid white; */
            }

            .restaurant-logo img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .restaurant-details {
                flex: 1;
                min-width: 0;
            }

            .restaurant-name {
                text-decoration: none;
                font-size: 1rem;
                font-weight: bold;
                color: #333;
                display: block;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .restaurant-rating {
                color: #ff9800;
                font-size: 0.8rem;
                margin-top: 3px;
            }



            .list-group-item {
                border: none;
                padding: 12px 15px;
                font-size: 0.9rem;
            }

            .list-group-item a {
                text-decoration: none;
                color: black;
                display: block;
            }

            .list-group-item.active {
                background-color: green;
                color: white;
            }

            .list-group-item.custom-border {
                border: 1px solid #d3d3d3;
                margin-bottom: 2px;
                padding: 12px 15px;
                line-height: 1.3;
            }

            .list-group-item i {
                margin-right: 10px;
                width: 16px;
                text-align: center;
            }

            .list-group-item:hover {
                background-color: green;
                cursor: pointer;
            }

            #moreToggle:hover {
                background-color: green;
                cursor: pointer;
            }

            .more-content {
                display: none;
            }

            /* Overlay to close sidebar on outside click */
            #overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.3);
                display: none;
                z-index: 9998;
            }

            /* Content */
            .content {
                margin-top: 70px; 
                height: calc(100vh - 70px);
                overflow-y: auto;
                padding-left: 10px;
                padding-right: 10px;

            }
        </style>
    </head>

    <body>
      
     
        <!-- top row -->
        <div class="topbar">
            <div class="left-section">
                <i class="fa-solid fa-chevron-left" onclick="history.back()" 
                style="cursor:pointer; font-size:18px;"></i>
                <h3 style="margin: 0;">@yield('page_title')</h3>
            </div>

            <div class="right-section">

                <a href="{{ url('admin/menu') }}">
                    <button class="main">
                        <i class="bi bi-cart" ></i><br>Menu
                    </button>
                </a>
                <a href="#">
                    <button class="main">
                        <i class="bi bi-shop" ></i><br>Orders
                    </button>
                </a>

                
                <button class="menu" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            </div>
        </div>

        <!-- sidebar -->
        <div class="offcanvas" id="sidebarMenu">

            <div class="restaurant-info">
                <div class="restaurant-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Master Chef">
                </div>
                <div class="restaurant-details">
                    <a href="#" h2 class="restaurant-name">Master Chef</h2></a>
                
                    <div class="restaurant-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <a href="#" style="text-decoration: none;">
                    <i class="fas fa-chevron-right text-secondary"></i>
                </a> 
            </div>


            <div class="offcanvas-body">
                <ul class="list-group">

                    <a href="{{url('admin/dashboard')}}"  class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center custom-border">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </li>
                    </a>

                    <a href="{{ url('admin/menu') }}" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center custom-border">
                            <i class="bi bi-menu-button-wide me-2"></i> Menu
                        </li>
                    </a>

                    <a href="{{url('admin/orders')}}"  class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center custom-border">
                            <i class="bi bi-file-earmark-text me-2"></i> Orders
                        </li>
                    </a>      

                    <a href="{{url('admin/take-payment')}}" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center custom-border">
                            <i class="bi bi-wallet me-2"></i>Take Payment</a>
                        </li>
                    </a>
                    
                    <a href="{{url('admin/website-status')}}" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center  custom-border">
                            <i class="bi bi-house-door me-2"></i> Website Status
                        </li>
                    </a>

                    <a href="{{url('admin/customers')}}" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center  custom-border">
                            <i class="bi bi-people me-2"></i> Customers
                        </li>
                    </a>

                    <a href="{{url('admin/business-hours')}}" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center custom-border">
                            <i class="bi bi-clock  me-2"></i>Business Hours</a>
                        </li>
                    </a>

                    <a href="{{url('admin/delivery-configuration')}}" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center custom-border">
                            <i class="bi bi-truck me-2"></i>Delivery Configuration</a>
                        </li>
                    </a>

                    <a href="{{url('admin/reviews')}}" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center  custom-border">
                            <i class="bi bi-star me-2"></i> Reviews
                        </li>
                    </a>

                    <a href="{{url('admin/billing')}}" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center  custom-border">
                            <i class="bi bi-receipt me-2"></i> Billing
                        </li>
                    </a>

                    <a href="{{url('admin/reports')}}" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center custom-border">
                            <i class="bi bi-bar-chart-line me-2"></i> Reports
                        </li>
                    </a>

                    <!-- <a href="#" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center custom-border">
                            <i class="bi bi-graph-up me-2"></i> Analytics</a>
                        </li>
                    </a> -->

                    <!-- <a href="#" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center custom-border">
                            <i class="bi bi-plug me-2"></i> Integrations
                        </li>
                    </a> -->

                    

                    <!-- <a href="#" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center custom-border">
                            <i class="bi bi-gift me-2"></i> Promotions
                        </li>
                    </a> -->

                    <!-- <a href="#" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center custom-border">
                            <i class="bi bi-star me-2"></i> Features
                        </li>
                    </a> -->

                    <a href="{{url('admin/orders')}}" class="text-decoration-none">
                        <li class="list-group-item d-flex align-items-center custom-border">
                            <i class="bi bi-gear me-2"></i> Settings
                        </li>
                    </a>

                    <li class="list-group-item d-flex align-items-center custom-border" id="moreToggle">
                        <i class="bi bi-three-dots-vertical me-2"></i> 
                        <a href="#" id="toggleMore">More</a>
                        <i class="bi bi-chevron-down ms-auto" id="chevronIcon"></i>
                    </li>

                    <div id="moreContent" class="more-content">
                        <a href="{{url('admin/orders')}}" class="text-decoration-none">
                            <li class="list-group-item d-flex align-items-center custom-border text-decoration-none" >
                                <i class="bi bi-headset me-2"></i>Support
                            </li>
                        </a>
    
                        <a href="{{url('admin/orders')}}" class="text-decoration-none">
                            <li class="list-group-item d-flex align-items-center custom-border">
                                <i class="bi bi-file-earmark-lock me-2"></i> Terms & Policy
                            </li>
                        </a>


                        <a href="{{url('admin/orders')}}" class="text-decoration-none">
                            <li class="list-group-item d-flex align-items-center custom-border">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </li>
                        </a>
                    </div>
                </ul>
            </div>
        </div>

       <!-- main content -->
        <div class="content">
            @yield('content')
        </div>
        <div id="overlay"></div>
    </body>

    
    <script>
        document.getElementById('moreToggle').addEventListener('click', function() {
            const moreContent = document.getElementById('moreContent');
            const toggleText = document.getElementById('toggleMore');
            const chevronIcon = document.getElementById('chevronIcon');

            moreContent.style.display = moreContent.style.display === 'none' || moreContent.style.display === '' ? 'block' : 'none';       
            toggleText.textContent = moreContent.style.display === 'none' ? 'More' : 'Less';
            chevronIcon.classList.toggle('bi-chevron-down');
            chevronIcon.classList.toggle('bi-chevron-up');
        });


        document.getElementById("toggleMore").addEventListener("click", function() {
            var moreContent = document.getElementById("moreContent");
            var chevronIcon = document.getElementById("chevronIcon");

            if (moreContent.style.display === "none" || moreContent.style.display === "") {
                moreContent.style.display = "block";
                chevronIcon.classList.remove("bi-chevron-down");
                chevronIcon.classList.add("bi-chevron-up");
            } else {
                moreContent.style.display = "none";
                chevronIcon.classList.remove("bi-chevron-up");
                chevronIcon.classList.add("bi-chevron-down");
            }
        });

        function toggleSidebar() {
            let sidebar = document.getElementById("sidebarMenu");
            let overlay = document.getElementById("overlay");

            sidebar.classList.add("show");
            overlay.style.display = "block";
        }

        // Close when clicking outside
        document.getElementById("overlay").addEventListener("click", function () {
            document.getElementById("sidebarMenu").classList.remove("show");
            this.style.display = "none";
        });
    </script>
</html>