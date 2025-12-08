@extends('admin.layout')

@section('title','Menu')
@section('page_title','Menu')

@section('content')


    <style>
        .wrapper {
            display: grid;
            grid-template-columns: 1fr 4fr;
            width: 100%;
            height: calc(100vh - 80px); /* optional */
        }

        .sidebar {
            background-color: #f8f9fa;
            padding: 15px;
            border-right: 1px solid #ddd;
        }
        
        .list-group-item:hover {
            background-color: #198754;
            color: #fff !important;
            cursor: pointer;
        }

        .list-group-item {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd; 
            transition: all 0.2s ease;
        }
        .list-group-item:last-child {
            border-bottom: none;
        }

        .list-group-item.active {
            background: linear-gradient(to right, #198754, #157347); 
            color: #fff !important;
            font-weight: 600;
            border-left: 4px solid #0f5132; 
            box-shadow: inset 0 0 5px rgba(0,0,0,0.1);
        }
        
        .btn-hover-success {
            background-color: transparent; 
            color: #198754 !important;
            border-color: #198754;
            margin-bottom: 1.5rem;
            width:100%;
        }

        .btn-hover-success:hover {
            background-color: #198754; 
            color: white !important;
            border-color: #198754;
        }

        .content-area {
            padding-left: 20px;
            background: #ffffff;
            overflow-y: auto;
        }

        /* ===== Responsive ===== */

        /* Tablets */
        @media (max-width: 992px) {
            .wrapper {
                grid-template-columns: 1fr 3fr;
            }
        }

        /* Small tablets / large phones */
        @media (max-width: 768px) {
            .wrapper {
                grid-template-columns: 1fr 2fr;
            }
            .sidebar {
                padding: 10px;
            }
            .list-group-item {
                padding: 8px 12px;
                font-size: 14px;
            }
            .btn-hover-success {
                font-size: 14px;
                padding: 8px;
            }
        }

        /* Mobile phones */
        @media (max-width: 576px) {
            .wrapper {
                grid-template-columns: 1fr; 
                height: auto;
            }
            .sidebar {
                border-right: none;
                border-bottom: 1px solid #ddd;
            }
            .content-area {
                padding: 15px;
            }
        }

    </style>


    <div class="wrapper">
        <div class="sidebar">
            <a href="{{url('client/orders')}}" class="btn w-100 btn-hover-success">Preview Website</a>

            <ul class="list-group">
                <li class="list-group-item" data-target="menus">Menu</li>
                <li class="list-group-item" data-target="categories">Categories</li>
                <li class="list-group-item" data-target="sub-categories">Sub Categories</li>
                <li class="list-group-item" data-target="items">Items</li>
                <li class="list-group-item" data-target="modifier-groups">Modifier Groups</li>
                <li class="list-group-item" data-target="modifiers">Modifiers</li>
                <li class="list-group-item" data-target="item-out-of-stock">Item Out Of Stock</li>
            </ul>
        </div>

        <div class="content-area">
            <div id="load-area">
                {{-- Default Load Categories --}}
                @include('admin.menus.menus')
            </div>
        </div>

    </div>

    <script>
        document.querySelectorAll(".list-group-item").forEach(item=>{
            item.addEventListener("click",function(){
                document.querySelectorAll(".list-group-item").forEach(i=>i.classList.remove("active"));
                this.classList.add("active");

                let target = this.getAttribute("data-target");

                fetch(`/admin/menus/load/${target}`)
                .then(response=>response.text())
                .then(html =>{
                    document.getElementById("load-area").innerHTML = html;
                });
            });
        });
    </script>

@endsection
