<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ isset($item) ? 'Update Item' : 'Add Item' }}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/add-update.css') }}">

    <style>
        .modifier-dropdown {
            /* border: 1px solid #ccc; */
            max-height: 200px;
            overflow-y: auto;
            padding:10px;
        }

        .modifier-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 10px;
            border-bottom: 1px solid #eee;
        }

        .modifier-row input[type="checkbox"] {
            margin-right: 10px;
        }

        .modifier-name { width: 40%; }
        .modifier-min  { width: 20%; text-align: center; }
        .modifier-max  { width: 20%; text-align: center; }
    </style>
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

<form method="POST"
      action="{{ isset($item) ? route('items.update', $item->item_id) : route('items.store') }}"
      enctype="multipart/form-data">

    @csrf
    @if(isset($item))
        @method('PUT')
    @endif

    <div class="category-box">

        <!-- IMAGE -->
        <div class="image-circle" onclick="document.getElementById('item_image').click()">
            @if(isset($item) && $item->item_image)
                <img src="{{ asset('storage/' . $item->item_image) }}">
            @else
                <span class="image-hint">Upload Image</span>
            @endif
        </div>

        <input type="file" id="item_image" name="item_image" hidden>

        <!-- SUB CATEGORY -->
        <input type="hidden"
               name="sub_cat_id"
               value="{{ $item->sub_cat_id ?? $subCategory->sub_cat_id }}">

        <!-- ITEM NAME -->
        <div class="form-group">
            <label>Item Name</label>
            <input type="text"
                   name="item_name"
                   value="{{ old('item_name', $item->item_name ?? '') }}"
                   required>
        </div>

        <!-- PRICE -->
        <div class="form-group">
            <label>Price</label>
            <input type="number"
                   step="0.01"
                   name="item_price"
                   value="{{ old('item_price', $item->item_price ?? '') }}"
                   required>
        </div>

        <!-- DESCRIPTION -->
        <div class="form-group">
            <label>Description</label>
            <textarea name="item_description">{{ old('item_description', $item->item_description ?? '') }}</textarea>
        </div>

        <!-- STATUS -->
        <div class="form-group1">
            <label>Status</label>
            <label class="switch">
                <input type="checkbox"
                       name="item_status"
                       value="1"
                       {{ (!isset($item) || $item->item_status == 1) ? 'checked' : '' }}>
                       <!-- {{ isset($item) && $item->item_status ? 'checked' : '' }}> -->
                <span class="slider"></span>
            </label>
        </div>
        

        <!-- MODIFIER GROUPS -->
        <div class="form-group">
            <label>Modifier Groups</label>

            @php
                $selectedGroups = isset($item) ? $item->modifierGroups->pluck('id')->toArray() : [];
            @endphp

            <div class="modifier-dropdown">
                <label class="modifier-row">
                    <span class="modifier-min">Modifier Group Name</span>
                    <span class="modifier-min"></span>
                    <span class="modifier-min">Min</span>
                    <span class="modifier-max">Max</span>
                </label>
                @foreach($modifierGroups as $group)
                    <label class="modifier-row">
                        <input type="checkbox" name="modifier_group_ids[]"
                            value="{{ $group->id }}"
                            {{ in_array($group->id, $selectedGroups) ? 'checked' : '' }}>
                        <span class="modifier-name">{{ $group->group_name }}</span>
                        <span class="modifier-min">{{ $group->min_select }}</span>
                        <span class="modifier-max">{{ $group->max_select }}</span>
                    </label>
                @endforeach
            </div>


            <!-- @if($modifierGroups->count() > 0)
            <select name="modifier_group_ids[]" class="form-control" multiple>
                @foreach($modifierGroups as $group)
                    <option value="{{ $group->id }}"
                        {{ in_array($group->id, $selectedGroups) ? 'selected' : '' }}>
                        {{ $group->group_name }} (Min: {{ $group->min_select }}, Max: {{ $group->max_select }})
                    </option>
                @endforeach
            </select>
            @else
            <p>No modifier groups available.</p>
            @endif -->

            <!-- <small class="text-muted">
                Hold CTRL (Windows) or CMD (Mac) to select multiple
            </small> -->
        </div>

        

    </div>

    <!-- FOOTER -->
    <div class="footer">

        @if(isset($item))
            <i class="fas fa-trash delete-icon"
               onclick="openDeletePopup()"></i>
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

<!-- DELETE POPUP -->
@if(isset($item))
<div id="deletePopup" style="display:none;">
    <div class="popup-overlay" onclick="closeDeletePopup()"></div>

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

<!-- IMAGE PREVIEW -->
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
</script>

</body>
</html>
