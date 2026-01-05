@extends('admin.layout')

@section('title','Reviews')
@section('page_title','Reviews')

@section('content')

<style>
    .admin-reviews-container {
        width: 95%;
        margin: 20px auto;
        font-family: 'Poppins', sans-serif;
    }

    /* Header & stats */
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .review-header h2 {
        font-size: 28px;
        font-weight: 600;
    }

    .review-stats span {
        margin-left: 15px;
        font-weight: 500;
        color: #555;
    }

    /* Grid */
    .reviews-grid-admin {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    /* Card */
    .review-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        position: relative;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .review-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    }

    .review-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .rating {
        color: #ff9800;
        font-size: 14px;
    }

    /* Delete button */
    .delete-btn {
        margin-top: 10px;
        padding: 6px 12px;
        background: #D32F2F;
        color: #fff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        align-self: flex-start;
        transition: 0.3s;
    }

    .delete-btn:hover {
        background: #b71c1c;
    }

    /* Pagination */
    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 600px) {
        .reviews-grid-admin {
            grid-template-columns: 1fr;
        }
    }

</style>
<div class="admin-reviews-container">

    <!-- Header / Stats -->
    <div class="review-header">
        <h2>Reviews</h2>
        <div class="review-stats">
            <span>Total: {{ $totalReviews }}</span>
            <span>Average: {{ $averageRating }} ⭐</span>
        </div>
    </div>

    <!-- Reviews Grid -->
    <div class="reviews-grid-admin">
        @forelse($reviews as $review)
            <div class="review-card">
                <div class="review-top">
                    <strong>{{ $review->name }}</strong>
                    <span class="rating">
                        {{ str_repeat('⭐', $review->rating) }}
                    </span>
                </div>
                <p>{{ $review->comment }}</p>
                <small>{{ $review->email ?? 'No Email' }} | {{ $review->created_at->format('d M, Y') }}</small>

                <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button class="delete-btn">Delete</button>
                </form>
            </div>
        @empty
            <p>No reviews found.</p>
        @endforelse
    </div>

    <div class="pagination">
        {{ $reviews->links() }}
    </div>

</div>

@endsection
