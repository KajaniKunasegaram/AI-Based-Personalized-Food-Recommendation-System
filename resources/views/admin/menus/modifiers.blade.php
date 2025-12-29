<link rel="stylesheet" href="{{ asset('css/admin/menus.css') }}">

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
    padding: 8px 5px;
}

.price-edit{
    background:transparent;
    border:1px solid lightgray;
    padding:3px;
    border-radius:5px;
}
</style>

<div id="modifiers">
    <div class="card">
        <div class="buttons">
            <input type="text" style="width:100%;" class="search-input" id="searchInput" placeholder="Search here...">            
        </div>
    </div>
</div>

<div class="category-box">
    <h3>Modifiers</h3>
    @forelse($modifiers as $modifier)
        <div class="category-rows">
            <span class="cat-name">
                {{ $modifier->name }}
                @if($modifier->modifier_group)
                    ({{ $modifier->modifier_group->group_name }})
                @endif
            </span>

            <div class="cat-actions">
                <span class="price-edit">£{{ number_format($modifier->price, 2) }}</span>

                <button class="btn btn-outline-secondary btn-sm"
                       >
                    Edit
                </button>

                <form method="POST" action="{{ route('modifiers.destroy', $modifier->id) }}" style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="margin-top:15px;" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Delete this modifier?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-muted mt-2">No modifiers found</p>
    @endforelse
</div>
