

<link rel="stylesheet" href="{{asset('css/admin/menus.css')}}">        


<div id="categories" >
    <div class="card">
        <div class="buttons">
            <input type="text" class="search-input" id="searchInput" placeholder="Search here...">
            <div class="d-flex gap-2">           
                <!-- <button id="toggleCollapseBtn" class="btn btn-outline-success">Collapse All</button> -->
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#sortCategoriesModal">Sort Categories</button>
                <button class="btn btn-outline-success" onclick="window.location='{{ route('categories.create') }}'">Add Category</button>
            </div>
        </div>
    </div>
</div>



<div class="category-box">

    <!-- Category Row -->


    <div class="category-row">
        <span class="cat-name">abc</span>

        <div class="cat-actions">
            <button class="btn btn-outline-secondary btn-sm">Edit Category</button>
            <button class="btn btn-outline-success btn-sm">+ Add SubCategory</button>
        </div>
    </div>
     

    <!-- Sub Category Row -->
    <div class="category-box">
        <div class="subcategory-row">
            <span class="subcat-name">2</span>

            <div class="subcat-actions">
                <button class="btn btn-outline-secondary btn-sm">Edit SubCategory</button>
                <button class="btn btn-outline-success btn-sm">+ Add Item</button>
            </div>
        </div>
        <!-- Item Row -->
        <div class="category-box">
            <div class="item-row">
                <span class="item-name">defswa</span>

                <div class="item-controls">
                    <span class="price">£0.12</span>

                    <select class="status-select">
                        <option>Available</option>
                        <option>Unavailable</option>
                    </select>
                  
                    <button class="btn btn-outline-secondary btn-sm">Edit</button>
                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                </div>
            </div>
        </div>
         <div class="category-box">
            <div class="item-row">
                <span class="item-name">defswa</span>

                <div class="item-controls">
                    <span class="price">£0.12</span>

                    <select class="status-select">
                        <option>Available</option>
                        <option>Unavailable</option>
                    </select>

                    <button class="btn btn-outline-secondary btn-sm">Edit</button>
                    <button class="btn btn-outline-danger btn-sm">Delete</button>
                </div>
            </div>
        </div>
    </div>

</div>


<script>

</script>

  

