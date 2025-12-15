

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

    .price-edit{
        background:transparent;
        border:1px solid lightgray;
        padding:3px;
        border-radius:5px;
    }
</style>

<div id="categories" >
    <div class="card">
        <div class="buttons">
            <input type="text" style="width:100%;" class="search-input" id="searchInput" placeholder="Search here...">            
        </div>
    </div>
</div>



<div class="category-box">
     <!-- <h3>Categories</h3> -->
    <div class="category-rows">
        <span class="cat-name">abc</span>

        <div class="cat-actions">
            <span class="price-edit">£0.12</span>
            <button class="btn btn-outline-secondary btn-sm">Edit</button>
            <button class="btn btn-outline-danger btn-sm">Delete</button>
            <!-- <button onclick="openAddCategoryModal()" class="btn btn-outline-success btn-sm">+ Add SubCategory</button> -->
        </div>
    </div>

    <div class="category-rows">
        <span class="cat-name">abc</span>

        <div class="cat-actions">
            <span class="price-edit">£0.12</span>
            <button class="btn btn-outline-secondary btn-sm">Edit</button>
            <button class="btn btn-outline-danger btn-sm">Delete</button>
            <!-- <button onclick="openAddCategoryModal()" class="btn btn-outline-success btn-sm">+ Add SubCategory</button> -->
        </div>
    </div>

    <div class="category-rows">
        <span class="cat-name">abc</span>

        <div class="cat-actions">
            <span class="price-edit">£0.12</span>
            <button class="btn btn-outline-secondary btn-sm">Edit</button>
            <button class="btn btn-outline-danger btn-sm">Delete</button>
            <!-- <button onclick="openAddCategoryModal()" class="btn btn-outline-success btn-sm">+ Add SubCategory</button> -->
        </div>
    </div>

</div>

 

