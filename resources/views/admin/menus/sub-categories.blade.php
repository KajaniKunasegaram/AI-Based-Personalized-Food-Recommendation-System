

<link rel="stylesheet" href="{{asset('css/admin/menus.css')}}">        

<style>
    .subcategory-rows{
    border: 1px solid #ddd;
    border-radius: 6px;
    background: #fff;
    margin: 10px 0;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.subcat-name{
    font-weight: 600;
}
.subcat-category{
    color: gray;
    font-size: 0.9rem;
}
</style>

<div id="categories" >
    <div class="card">
        <div class="buttons">
            <input type="text" class="search-input" id="searchInput" placeholder="Search here...">
            <div class="d-flex gap-2">           
                <!-- <button id="toggleCollapseBtn" class="btn btn-outline-success">Collapse All</button> -->
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#sortCategoriesModal">Sort Sub Categories</button>
                <!-- <button onclick="openCategoryModal()" class="btn btn-outline-success">Add Category</button> -->
            </div>
        </div>
    </div>
</div>

<div class="subcategory-box">
    <h3>Sub Categories</h3>

    @forelse($subCategories as $sub)
        <div class="subcategory-rows">
            <div>
                <span class="subcat-name">{{ $sub->sub_cat_name }}</span><br>
                <span class="subcat-category">({{ $sub->category->cat_name ?? 'N/A' }})</span>
            </div>

            <div class="subcat-actions">
                <button class="btn btn-outline-secondary btn-sm" 
                onclick="window.location='{{ route('subCategories.edit', $sub->sub_cat_id) }}'">Edit</button>
            </div>
        </div>
    @empty
        <p class="text-muted">No sub-categories found</p>
    @endforelse
</div>

<!-- <div class="category-box">
  
     <h3>Sub Categories</h3>

    

    <div class="category-rows">
        <span class="cat-name">abc</span>

        <div class="cat-actions">
            <button class="btn btn-outline-secondary btn-sm">Edit Sub Category</button>
            <button onclick="openAddCategoryModal()" class="btn btn-outline-success btn-sm">+ Add SubCategory</button>
        </div>
    </div>

  
</div> -->

