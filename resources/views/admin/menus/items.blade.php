

<link rel="stylesheet" href="{{asset('css/admin/menus.css')}}">        

<!-- <style>
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
</style> -->

<style>
.item-rows{
    border: 1px solid #ddd;
    border-radius: 6px;
    background: #fff;
    margin: 10px 0;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.item-name{
    font-weight: 600;
}
.item-category{
    color: gray;
    font-size: 0.9rem;
}
.item-price{
    font-weight: 500;
    color: #198754;
}
</style>
<div id="categories" >
    <div class="card">
        <div class="buttons">
            <input type="text" class="search-input" id="searchInput" placeholder="Search here...">
            <div class="d-flex gap-2">           
                <!-- <button id="toggleCollapseBtn" class="btn btn-outline-success">Collapse All</button> -->
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#sortCategoriesModal">Sort Items</button>
                <!-- <button onclick="openCategoryModal()" class="btn btn-outline-success">Add Category</button> -->
            </div>
        </div>
    </div>
</div>

<div>
    <h3>Items</h3>
 @forelse($items as $item)
        <div class="item-rows">
            <div>
                <span class="item-name">{{ $item->item_name }}</span><br>
                <span class="item-category">
                    Category: {{ $item->subCategory->category->cat_name ?? 'N/A' }} | 
                    Sub: {{ $item->subCategory->sub_cat_name ?? 'N/A' }}
                </span>
            </div>

            <div>
                <span class="item-price">${{ number_format($item->item_price, 2) }}</span>
                <button class="btn btn-outline-secondary btn-sm ms-2" 
                onclick="window.location='{{ route('items.edit', $item->item_id) }}'">Edit</button>
            </div>
        </div>
    @empty
        <p class="text-muted">No items found</p>
    @endforelse
</div>
<!-- <div class="category-box">
     <h3>Items</h3>
    <div class="category-rows">
        <span class="cat-name">abc</span>

        <div class="cat-actions">
            <button class="btn btn-outline-secondary btn-sm">Edit Category</button>
            <button onclick="openAddCategoryModal()" class="btn btn-outline-success btn-sm">+ Add SubCategory</button>
        </div>
    </div>

    
</div> -->

