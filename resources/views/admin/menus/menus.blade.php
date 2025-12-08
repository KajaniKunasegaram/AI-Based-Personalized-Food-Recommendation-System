

<link rel="stylesheet" href="{{asset('css/admin/menus.css')}}">        


<div id="categories" >
    <div class="card">
        <div class="buttons">
            <input type="text" class="search-input" id="searchInput" placeholder="Search here...">
            <div class="d-flex gap-2">           
                <button id="toggleCollapseBtn" class="btn border-success text-success">Collapse All</button>
                <button class="btn border-success text-success" data-bs-toggle="modal" data-bs-target="#sortCategoriesModal">Sort Categories</button>
                <button onclick="openCategoryModal()" class="btn border-success text-success">Add Category</button>
            </div>
        </div>
    </div>
</div>
 <div id="successMessage" class="alert alert-success text-center">
Category added successfully!    </div>

<div id="addCategoryModal" class="modal-overlay">
    <div class="category-box">
        <div class="modal-header justify-content-center position-relative">
            <h5 class="modal-title text-center" id="addCategoryLabel">Add Category</h5>
            <button type="button" class="btn-close position-absolute end-0 top-0 m-3" onclick="closeModal()"></button>
        </div>
            <!-- <div class="title">Add Category</div> -->
        
        <div class="image-circle" onclick="document.getElementById('cat_image').click();">
            <span class="image-hint">Upload Image</span>
        </div>

        <form action="{{route('categories.store')}}" method="POST" enctype="multipart/form-data">

            @csrf
            <input type="file" id="cat_image" name="cat_image" style="display:none;">

            <div class="form-group">
                <label>Category Name</label>
                <input class="catname" name="cat_name" type="text" placeholder="Pizza, Burger, Drinks....">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea class="catname" name="cat_description" placeholder="Short description"></textarea>
            </div>

            <div class="status">
                <label>Availability</label><br>
                <label class="switch">
                    <input type="checkbox" name="cat_status" value="1" checked>
                    <span class="slider"></span>
                </label>
            </div>

            <div class="btns">
                <button type="button" class="btn-cancel">Cancel</button>
                <button type="submit" class="btn-save">Save</button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div id="successMessage" class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif

<script>
    function openCategoryModal() {
        document.getElementById('addCategoryModal').classList.add('show');
    }

    function closeModal() {
        document.getElementById('addCategoryModal').classList.remove('show');
    }

    // Optional: click outside modal to close
    window.addEventListener('click', function(e){
        const modal = document.getElementById('addCategoryModal');
        if(e.target === modal){
            closeModal();
        }
    });

    // Selected image view

    const cat_image=document.getElementById('cat_image');
    const imgBox = document.querySelector('.image-circle');

    cat_image.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        const img = document.createElement("img");
        img.src = URL.createObjectURL(file);

        imgBox.innerHTML = "";
        imgBox.appendChild(img);
    });


    // setTimeout(function() {
    //     var msg = document.getElementById('successMessage');
    //     if(msg) {
    //         msg.style.display = 'none';
    //     }
    // }, 3000);
</script>

  

