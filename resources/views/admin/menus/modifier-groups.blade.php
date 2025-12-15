

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
        padding: 4px 5px;
    }
    .subcat-header {
        border-radius: 6px;       
        width: 100%;
        background: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

   

</style>

<div id="categories" >
    <div class="card">
        <div class="buttons">
            <input type="text" class="search-input" id="searchInput" placeholder="Search here...">
            <div class="d-flex gap-2">           
                <!-- <button id="toggleCollapseBtn" class="btn btn-outline-success">Collapse All</button> -->
                <!-- <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#sortCategoriesModal">Sort Categories</button> -->
                <button onclick="openCategoryModal()" class="btn btn-outline-success">ADD MODIFIER GROUPS</button>
            </div>
        </div>
    </div>
</div>



<div class="category-box">
    <!-- Category Row -->
     <div class="subcat-header">
        <h5>Group Name</h5>
        <h5 style="margin-left:-50px;">Min</h5>
        <h5>Max</h5>
        <h5>Action</h5>
     </div>
    <div class="category-rows">   
        <p>adsad</p>
        <p>0.01</p>
        <p>0.01</p>
        <button class="btn btn-outline-secondary btn-sm">Edit</button>
    </div>  

    <div class="category-rows">   
        <p>adsad</p>
        <p>0.01</p>
        <p>0.01</p>
        <button class="btn btn-outline-secondary btn-sm">Edit</button>
    </div> 

    <div class="category-rows">   
        <p>adsad</p>
        <p>0.01</p>
        <p>0.01</p>
        <button class="btn btn-outline-secondary btn-sm">Edit</button>
    </div> 
</div>

