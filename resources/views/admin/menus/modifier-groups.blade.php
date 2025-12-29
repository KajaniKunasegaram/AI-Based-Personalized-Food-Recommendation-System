
<link rel="stylesheet" href="{{asset('css/admin/menus.css')}}">        

<style>
    /* .category-rows{
        border: 1px solid #ddd;
        border-radius: 6px;       
        width: 100%;
        background: #fff;
        margin: 10px auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 4px 5px;
    } */

        .category-rows{
    border: 1px solid #ddd;
    border-radius: 6px;
    width: 100%;
    background: #fff;
    margin: 10px auto;

    display: grid;
    grid-template-columns: 1fr 1fr 1fr 0.5fr ;  /* 3 columns */
    
    align-items: center;
    padding: 6px 10px;
    gap: 10px;
}
    .subcat-header {
        border-radius: 6px;       
        width: 100%;
        background: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
/* ✅ Popup wrapper */
.add-modifier-group-popup {
    display: none; /* hidden initially */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
}

/* overlay */
.add-modifier-group-popup-overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    top: 0;
    left: 0;
}

/* popup box */
.add-modifier-group-popup-box {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    padding: 20px 30px;
    border-radius: 10px;
    width: 400px;
    max-width: 90%;
    z-index: 10000;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

/* popup buttons */
.add-modifier-group-popup .popup-buttons {
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:10px;
}


</style>



<div id="categories" >
    <div class="card">
        <div class="buttons">
            <input type="text" class="search-input" id="searchInput" placeholder="Search here...">
            <div class="d-flex gap-2">           
                <!-- <button id="toggleCollapseBtn" class="btn btn-outline-success">Collapse All</button> -->
                <!-- <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#sortCategoriesModal">Sort Categories</button> -->
                <button  class="btn btn-outline-success"  onclick="window.location='{{ route('modifier-groups.create') }}'">ADD MODIFIER GROUPS</button>
            </div>
        </div>
    </div>
</div>

<div class="category-box">
    <!-- Category Row -->
     <div class="category-rows">
        <h5>Group Name</h5>
        <h5>Min</h5>
        <h5>Max</h5>
        <h5>Action</h5>

     </div>
     @foreach($groups as $group)
    <div class="category-rows">   
        <p>{{ $group->group_name }}</p>
        <p>{{ $group->min_select }}</p>
        <p>{{ $group->max_select }}</p>
        <div>
            <button class="btn btn-outline-secondary btn-sm" style="width:50px;" onclick="window.location='{{ route('modifier-groups.edit',$group->id) }}'">Edit</button>
            <form method="POST"
                action="{{ route('modifier-groups.delete', $group->id) }}"
                style="display:inline-block">

                @csrf
                @method('DELETE')

                <button class="btn btn-outline-danger btn-sm"
                        type="submit"
                        onclick="return confirm('Delete this modifier group?')">
                    Delete
                </button>
            </form>        
        </div>
    </div> 
    @endforeach  
</div>





