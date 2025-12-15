

<link rel="stylesheet" href="{{asset('css/admin/menus.css')}}">        

<style>
    .category-rows{
        border: 1px solid #ddd;
        border-radius: 6px;       
        width: 100%;
        background: #fff;
        margin: 10px auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 5px;
    }
</style>

<div id="categories" >
    <div class="card">
        <div class="buttons">
            <input type="text" class="search-input" id="searchInput" placeholder="Search here...">
            <div class="d-flex gap-2">           
                <!-- <button id="toggleCollapseBtn" class="btn btn-outline-success">Collapse All</button> -->
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#sortCategoriesModal">Sort Categories</button>
                <!-- <button onclick="openCategoryModal()" class="btn btn-outline-success">Add Category</button> -->
            </div>
        </div>
    </div>
</div>



<div class="category-box">
    <!-- Category Row -->
     <h3>Categories</h3>
    <div class="category-rows">
        <span class="cat-name">abc</span>

        <div class="cat-actions">
            <!-- <button class="btn btn-outline-secondary btn-sm">Edit Category</button> -->
            <!-- <button onclick="openAddCategoryModal()" class="btn btn-outline-success btn-sm">+ Add SubCategory</button> -->
        </div>
    </div>

    <div class="category-rows">
        <span class="cat-name">abc</span>

        <div class="cat-actions">
            <!-- <button class="btn btn-outline-secondary btn-sm">Edit Category</button> -->
            <!-- <button onclick="openAddCategoryModal()" class="btn btn-outline-success btn-sm">+ Add SubCategory</button> -->
        </div>
    </div>

    <div class="category-rows">
        <span class="cat-name">abc</span>

        <div class="cat-actions">
            <!-- <button class="btn btn-outline-secondary btn-sm">Edit Category</button> -->
            <!-- <button onclick="openAddCategoryModal()" class="btn btn-outline-success btn-sm">+ Add SubCategory</button> -->
        </div>
    </div>
</div>



<!-- Add Category Model -->

  

