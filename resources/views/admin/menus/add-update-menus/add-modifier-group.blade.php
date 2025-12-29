

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/admin/add-update.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/add-modifier-group.css') }}">

{{-- Success Message --}}
@if(session('success'))
<div class="alert alert-success mt-2" id="successAlert">
    {{ session('success') }}
</div>
@endif

<div class="header">
    <i class="fa-solid fa-chevron-left" onclick="window.location='{{ url('/admin/menu?tab=modifier-groups') }}'"></i>
    <div class="header-title">
        {{ $mode == 'add' ? 'Add Modifier Group' : 'Update Modifier Group' }}
    </div>
</div>

{{-- MODIFIER GROUP FORM --}}
<div class="group-form" style="width: 98%; margin: 0 auto; background:white; border:1px solid lightgray; padding:20px; border-radius:8px;">
    <form method="POST" action="{{ $mode=='add' ? route('modifier-groups.store') : route('modifier-groups.update', $group->id) }}">
        @csrf
        @if($mode=='edit')
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Group Name</label>
            <input type="text" name="group_name" class="form-control" value="{{ $mode=='edit' ? $group->group_name : '' }}" required>
        </div>

        <div class="form-group">
            <label>Min Select</label>
            <input type="number" name="min_select" class="form-control" value="{{ $mode=='edit' ? $group->min_select : 0 }}" min="0">
        </div>

        <div class="form-group">
            <label>Max Select</label>
            <input type="number" name="max_select" class="form-control" value="{{ $mode=='edit' ? $group->max_select : 0 }}" min="0">
        </div>

        <div class="form-group1">
            <label>Allow multiple modifiers</label>
            <label class="switch">
                <input type="checkbox" name="status" value="1" {{ $mode=='edit' && $group->status ? 'checked' : '' }}>
                <span class="slider"></span>
            </label>
        </div>

        <div style="width: 100%; margin-top:10px; background: white; border:1px solid lightgray; padding: 10px; display: flex; justify-content: space-between; align-items: center;">
            
            <!-- <div>
                @if($mode !== 'add')
                <form method="POST"
                    action="{{ route('modifier-groups.delete', $group->id) }}"
                    style="display:inline-block">

                    @csrf
                    @method('DELETE')

                    <button type="submit" onclick="return confirm('Delete this modifier group?')" style="background:none; border:none; padding:0;">
                        <i class="fas fa-trash delete-icon" style="color:red; cursor:pointer;"></i>
                    </button>
                </form>        
                @endif
            </div> -->

            <div class="d-flex gap-2">
                <button type="button" class="btn btn-cancel" 
                    onclick="window.location='{{ url('/admin/menu?tab=modifier-groups') }}'">Cancel</button>
                <button type="submit" class="btn btn-save-modifier">
                    {{ $mode == 'add' ? 'Save group' : 'Update group' }}
                </button>
            </div>
        </div>

    </form>
</div>



{{-- MODIFIERS TABLE (only in edit mode) --}}
@if($mode=='edit')
<div style=" width: 98%;  margin:12px; background: white; border:1px solid lightgray;
    padding: 20px; border-radius: 8px;">

    <div class="modifier-header">
        <div class="modifier-title">Modifiers</div>
        <button type="button" class="add-modifier-btn">+ Add Modifier</button>
    </div>

    <div class="modifier-row-head">
        <div>Name</div>
        <div>Price</div>
        <div>Min</div>
        <div>Max</div>
        <div>Status</div>
        <div>Action</div>
    </div>

    @forelse($modifiers as $modifier)
    <div class="modifier-row">
        <div>{{ $modifier->name }}</div>
        <div>{{ number_format($modifier->price,2) }}</div>
        <div>{{ $modifier->min }}</div>
        <div>{{ $modifier->max }}</div>
        <div>{{ $modifier->status ? 'Available' : 'Unavailable' }}</div>
        <div>
            <button type="button" class="edit" onclick="openEditModifier({{ $modifier->id }}, '{{ $modifier->name }}', {{ $modifier->price }}, {{ $modifier->min }}, {{ $modifier->max }}, {{ $modifier->status }})">Edit</button>

            <form method="POST" action="{{ route('modifiers.destroy', $modifier->id) }}" style="display:inline-block">
                @csrf
                @method('DELETE')
                
                <button type="submit" class="delete" onclick="return confirm('Delete this modifier?')">Delete</button>
            </form>
        </div>
    </div>
    @empty
        <p style="padding:10px;color:gray;">No modifiers added yet</p>
    @endforelse
</div>

{{-- ADD/EDIT MODIFIER MODAL --}}
<div id="addModifierModal" class="modifier-modal">
    <div class="modifier-modal-overlay" onclick="closeAddModifier()"></div>
    <div class="modifier-modal-box">
        <div class="modifier-modal-header">
            <h3>Modifier</h3>
            <span class="close-btn" onclick="closeAddModifier()">×</span>
        </div>

        <div class="modifier-modal-body">
            <form id="modifierForm" method="POST">
                @csrf
                <input type="hidden" name="group_id" value="{{ $group->id }}">
                <input type="hidden" id="modifier_id" name="modifier_id">

                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input type="number" id="price" name="price" class="form-control" value="0.00" step="0.01">
                </div>

                <div class="modifier-grid-2">
                    <div>
                        <label>Min</label>
                        <input type="number" id="min" name="min" class="form-control" value="0">
                    </div>
                    <div>
                        <label>Max</label>
                        <input type="number" id="max" name="max" class="form-control" value="0">
                    </div>
                </div>

                <div class="modifier-grid-2 status-row">
                    <label>Status</label>
                    <label class="switch">
                        <input type="checkbox" id="status" name="status" value="1">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="modifier-modal-footer mt-2">
                    <button type="button" class="btn btn-cancel" onclick="closeAddModifier()">Cancel</button>
                    <button type="submit" class="btn btn-save-modifier">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- Scripts --}}
<script>
    // Open add modifier modal
    document.querySelector('.add-modifier-btn')?.addEventListener('click', function () {
        document.getElementById('modifierForm').reset();
        document.getElementById('modifier_id').value = '';
        document.getElementById('addModifierModal').style.display = 'block';
    });

    function closeAddModifier() {
        document.getElementById('addModifierModal').style.display = 'none';
    }

    // Open edit modifier modal
    function openEditModifier(id, name, price, min, max, status) {
        document.getElementById('modifier_id').value = id;
        document.getElementById('name').value = name;
        document.getElementById('price').value = price;
        document.getElementById('min').value = min;
        document.getElementById('max').value = max;
        document.getElementById('status').checked = status ? true : false;
        document.getElementById('addModifierModal').style.display = 'block';
    }

    // Submit modifier form
    document.getElementById('modifierForm')?.addEventListener('submit', function(e){
        e.preventDefault();
        let id = document.getElementById('modifier_id').value;
        let url = id ? '/admin/modifiers/update/' + id : '/admin/modifiers/store';
        this.action = url;
        this.method = 'POST';
        this.submit();
    });

     document.addEventListener("DOMContentLoaded", function() {
        const alert = document.getElementById('successAlert');
        if(alert) {
            setTimeout(() => {
                alert.style.opacity = '0';           // fade out
                setTimeout(() => alert.remove(), 500); // remove from DOM
            }, 3000); // 3000ms = 3 seconds
        }
    });
</script>
