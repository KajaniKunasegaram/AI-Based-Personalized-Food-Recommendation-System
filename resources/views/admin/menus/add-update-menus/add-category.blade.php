<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{ isset($category) ? 'Update Category' : 'Add Category' }}</title>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{asset('css/admin/add-update.css')}}">

</head>

<body>

<!-- HEADER -->
<div class="header">
    <i class="fa-solid fa-chevron-left" onclick="window.location='{{ url('/admin/menu') }}'"></i>
    <div class="header-title">
        {{ isset($category) ? 'Update Category' : 'Add Category' }}
    </div>
</div>

<form action="{{ isset($category) 
        ? route('categories.update', $category->cat_id) 
        : route('categories.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($category))
        @method('PUT')
    @endif
<div class="category-box">

    <div class="image-circle" onclick="document.getElementById('cat_image').click()">
        <!-- <span class="image-hint">Upload Image</span> -->
        @if(!empty($category->cat_image))
            <img src="{{ asset('storage/' . $category->cat_image) }}" alt="Category Image">
        @else
            <span class="image-hint">Upload Image</span>
        @endif
    </div>

    <input type="file" id="cat_image" name="cat_image"  hidden>

    <div class="form-group">
        <label>Category Name</label>
        <input type="text" name="cat_name" value="{{ $category->cat_name ?? '' }}" required>
        <!-- <input type="text" name="cat_name" required> -->
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="cat_description">{{ $category->cat_description ?? '' }}</textarea>

        <!-- <textarea name="cat_description"></textarea> -->
    </div>

    <div class="form-group1">
        <label>Status</label>
        <label class="switch">
            <input type="checkbox" name="cat_status" 
            value="1" 
            {{ (!isset($category) || $category->cat_status == 1) ? 'checked' : '' }}>
            <!-- {{ isset($category) && $category->cat_status ? 'checked' : '' }}> -->
            <!-- <input type="checkbox" name="cat_status" value="1" checked> -->
            <span class="slider"></span>
        </label>
    </div>

</div>

<div class="footer">
    <!-- <i class="fas fa-trash delete-icon" onclick="openDeletePopup()"></i> -->
    @if(isset($category))
        <i class="fas fa-trash delete-icon" onclick="openDeletePopup()"></i>
    @endif
    <div class="footer-right">
        <button type="button" class="btn btn-cancel" onclick="window.location='{{ url('/admin/menu') }}'">Cancel</button>
        <button type="submit" class="btn btn-save">{{ isset($category) ? 'Update' : 'Save' }}</button>
    </div>
</div>

</form>
@if(session('success'))
    <div id="successMessage" class="success-msg">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<!-- <div id="successMessage" class="success-msg">
    <i class="fa-solid fa-circle-check"></i> Category added successfully!
</div> -->

<!-- DELETE CONFIRM MODAL -->
 @if(isset($category))
<div id="deletePopup" style="display:none;">
    <div class="popup-overlay"></div>
    <div class="popup-box">
        <h3>Are you sure?</h3>
        <p>You want to delete this category.</p>
        <div class="popup-buttons">
            <button class="btn btn-cancel" onclick="closeDeletePopup()">Cancel</button>
            <form method="POST"
                  action="{{ route('categories.destroy', $category->cat_id) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-save">Delete</button>
            </form>
            <!-- <button class="btn btn-save"  onclick="performDelete()">Delete</button> -->
        </div>
    </div>
</div>
@endif



<script>
    const input = document.getElementById('cat_image');
    const box = document.querySelector('.image-circle');

    input.addEventListener('change', () => {
        const file = input.files[0];
        if (!file) return;

        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        box.innerHTML = '';
        box.appendChild(img);
    });

    function openDeletePopup() {
        document.getElementById('deletePopup').style.display = 'block';
    }

    function closeDeletePopup() {
        document.getElementById('deletePopup').style.display = 'none';
    }

   

    setTimeout(() => {
        const msg = document.getElementById('successMessage');
        if (msg) {
            msg.style.transition = "all 0.5s ease";
            msg.style.opacity = 0;
            msg.style.transform = "translate(-50%, -20px)";
            setTimeout(() => msg.remove(), 500);
        }
    }, 3000);
</script>

</body>
</html>
