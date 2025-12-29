<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($item) ? 'Update Item' : 'Add Item' }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/add-update.css') }}">
</head>

<body>

<!-- HEADER -->
<div class="header">
    <i class="fa-solid fa-chevron-left"
       onclick="window.location='{{ url('/admin/menu') }}'"></i>
    <div class="header-title">
        {{ isset($item) ? 'Update Item' : 'Add Item' }}
    </div>
</div>

<form action="{{ isset($item)
        ? route('items.update', $item->item_id)
        : route('items.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($item))
        @method('PUT')
    @endif

<div class="category-box">

    <!-- IMAGE -->
    <div class="image-circle" onclick="document.getElementById('item_image').click()">
        @if(!empty($item->item_image))
            <img src="{{ asset('storage/' . $item->item_image) }}">
        @else
            <span class="image-hint">Upload Image</span>
        @endif
    </div>

    <input type="file" id="item_image" name="item_image" hidden>

    <!-- SUB CATEGORY ID -->
    <input type="hidden"
           name="sub_cat_id"
           value="{{ $item->sub_cat_id ?? $subCategory->sub_cat_id }}">

    <!-- ITEM NAME -->
    <div class="form-group">
        <label>Item Name</label>
        <input type="text" name="item_name" value="{{ $item->item_name ?? '' }}" required>
    </div>

    <!-- PRICE -->
    <div class="form-group">
        <label>Price</label>
        <input type="number" step="0.01" name="item_price" value="{{ $item->item_price ?? '' }}" required>
    </div>

    <!-- DESCRIPTION -->
    <div class="form-group">
        <label>Description</label>
        <textarea name="item_description">{{ $item->item_description ?? '' }}</textarea>
    </div>

    <!-- STATUS -->
    <div class="form-group1">
        <label>Status</label>
        <label class="switch">
            <input type="checkbox"
                   name="item_status"
                   value="1"
                   {{ isset($item) && $item->item_status ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
    </div>

</div>

<!-- FOOTER -->
<div class="footer">
    @if(isset($item))
        <i class="fas fa-trash delete-icon" onclick="openDeletePopup()"></i>
    @endif

    <div class="footer-right">
        <button type="button"
                class="btn btn-cancel"
                onclick="window.location='{{ url('/admin/menu') }}'">
            Cancel
        </button>

        <button type="submit" class="btn btn-save">
            {{ isset($item) ? 'Update' : 'Save' }}
        </button>
    </div>
</div>

</form>

<!-- SUCCESS / ERROR -->
@if (session('success'))
    <div id="successMessage" class="success-msg">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
@elseif ($errors->any())
    <div id="errorMessage" class="error-msg">
        <i class="fa-solid fa-circle-xmark"></i>
        {{ $errors->first() }}
    </div>
@endif

<!-- DELETE POPUP -->
@if(isset($item))
<div id="deletePopup" style="display:none;">
    <div class="popup-overlay"></div>
    <div class="popup-box">
        <h3>Are you sure?</h3>
        <p>You want to delete this item.</p>

        <div class="popup-buttons">
            <button class="btn btn-cancel" onclick="closeDeletePopup()">Cancel</button>

            <form method="POST"
                  action="{{ route('items.destroy', $item->item_id) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-save">Delete</button>
            </form>
        </div>
    </div>
</div>
@endif

<script>
    const input = document.getElementById('item_image');
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
        document.getElementById('successMessage')?.remove();
        document.getElementById('errorMessage')?.remove();
    }, 3000);
</script>

</body>
</html>
