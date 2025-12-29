<link rel="stylesheet" href="{{ asset('css/admin/menus.css') }}">


<!-- ✅ GLOBAL SUCCESS MESSAGE (FOR SESSION + AJAX) -->
<div id="successMessage" class="success-msg" style="display:none;">
    <i class="fa-solid fa-circle-check"></i>
    <span id="successText"></span>
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {

        if (sessionStorage.getItem('skipSessionSuccess')) {
            sessionStorage.removeItem('skipSessionSuccess');
            return;
        }

        showSuccessMessage("{{ session('success') }}");
    });
</script>
@endif


<div id="categories">
    <div class="card">
        <div class="buttons">
            <input type="text" class="search-input" id="searchInput" placeholder="Search here...">
            <div class="d-flex gap-2">
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#sortCategoriesModal">
                    Sort Categories
                </button>
                <button class="btn btn-outline-success"
                    onclick="window.location='{{ route('categories.create') }}'">
                    Add Category
                </button>
            </div>
        </div>
    </div>
</div>


@foreach($categories as $category)
<div class="category-box">

    <!-- Category Row -->
    <div class="category-row">
        <span class="cat-name">{{ $category->cat_name }}</span>

        <div class="cat-actions">
            <button class="btn btn-outline-secondary btn-sm"
                onclick="window.location='{{ route('categories.edit', $category->cat_id) }}'">
                Edit Category
            </button>

            <button class="btn btn-outline-success btn-sm"
                onclick="window.location='{{ route('subCategories.create', $category->cat_id) }}'">
                + Add SubCategory
            </button>
        </div>
    </div>

    <!-- Sub Categories -->
    @foreach($category->subCategories as $sub)
    <div class="category-box">

        <div class="subcategory-row">
            <span class="subcat-name">{{ $sub->sub_cat_name }}</span>

            <div class="subcat-actions">
                <button class="btn btn-outline-secondary btn-sm"
                    onclick="window.location='{{ route('subCategories.edit', $sub->sub_cat_id) }}'">
                    Edit SubCategory
                </button>

                <button class="btn btn-outline-success btn-sm"
                    onclick="window.location='{{ route('items.create', $sub->sub_cat_id) }}'">
                    + Add Item
                </button>
            </div>
        </div>

        <!-- Items -->
        @foreach($sub->items as $item)
        <div class="category-box">
            <div class="item-row">
                <span class="item-name">{{ $item->item_name }}</span>

                <div class="item-controls">
                    <span class="price">£{{ $item->item_price }}</span>

                    <select class="status-select"
                        onchange="updateItemStatus({{ $item->item_id }}, this.value)">
                        <option value="1" {{ $item->item_status ? 'selected' : '' }}>
                            Available
                        </option>
                        <option value="0" {{ !$item->item_status ? 'selected' : '' }}>
                            Unavailable
                        </option>
                    </select>

                    <button class="btn btn-outline-secondary btn-sm"
                        onclick="window.location='{{ route('items.edit', $item->item_id) }}'">
                        Edit
                    </button>

                    <button class="btn btn-outline-danger btn-sm"
                        onclick="openDeletePopup({{ $item->item_id }})">
                        Delete
                    </button>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    @endforeach

</div>
@endforeach


<!-- DELETE CONFIRM POPUP -->
<div id="deletePopup" class="popup-wrapper" style="display:none;">
    <div class="popup-overlay" onclick="closeDeletePopup()"></div>

    <div class="popup-box">
        <h3 style="font-weight:bold;">Are you sure?</h3>
        <p>You want to delete this item.</p>

        <div class="popup-buttons">
            <button class="btn btn-cancel" onclick="closeDeletePopup()">Cancel</button>

            <button class="btn btn-save" onclick="confirmDeleteItem()">Delete</button>
        </div>
    </div>
</div>

<script>
    /* ✅ SHOW SUCCESS MESSAGE */
    function showSuccessMessage(message) {
        const box = document.getElementById('successMessage');
        const text = document.getElementById('successText');

        text.innerText = message;
        box.style.display = 'block';
        box.style.opacity = 1;
        box.style.transform = 'translate(-50%, 0)';

        setTimeout(() => {
            box.style.opacity = 0;
            box.style.transform = 'translate(-50%, -20px)';
            setTimeout(() => box.style.display = 'none', 500);
        }, 2500);
    }


    /* ✅ UPDATE ITEM STATUS */
    function updateItemStatus(itemId, status) {
        fetch(`/admin/items/${itemId}/status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ item_status: status })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showSuccessMessage('Item status updated successfully!');
            } else {
                alert('Status update failed');
            }
        });
    }



    let deleteItemId = null;

    /* OPEN POPUP */
    function openDeletePopup(itemId) {
        deleteItemId = itemId;
        document.getElementById('deletePopup').style.display = 'block';
    }

    /* CLOSE POPUP */
    function closeDeletePopup() {
        deleteItemId = null;
        document.getElementById('deletePopup').style.display = 'none';
    }

    /* CONFIRM DELETE */
    function confirmDeleteItem() {
        if (!deleteItemId) return;

        fetch(`/admin/items/${deleteItemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            // 🔥 CLOSE POPUP ALWAYS (JSON irundhaalum illaattiyum)
            closeDeletePopup();

            // Try to read JSON safely
            return response.text();
        })
        .then(() => {

        // ✅ FLAG SET (reload la session msg varama irukka)
            sessionStorage.setItem('skipSessionSuccess', 'true');

            showSuccessMessage('Item deleted successfully!');

            setTimeout(() => {
                location.reload();
            }, 3000);
        })
        .catch(() => {
            closeDeletePopup();
            alert('Something went wrong');
        });
    }
</script>
