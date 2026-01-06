@extends('client.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/client/reviews.css') }}">

<div class="reviews-container">

    <div class="reviews-header">
        <h2>Customer Reviews</h2>

        <a href="{{ route('orders') }}" class="order-btn">
            Order Now
        </a>
    </div>
    <!-- Success Message -->
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    
    <!-- TWO COLUMN WRAPPER -->
    <div class="reviews-grid">

        <!-- LEFT : Reviews List -->
        <div class="reviews-list">
            <h3>Reviews ⭐⭐⭐⭐⭐</h3>

            @forelse($reviews as $review)
                <div class="review-item">
                    <div class="review-header">
                        <strong>{{ $review->name }}</strong>
                        <span class="rating">{{ str_repeat('⭐', $review->rating) }}</span>
                    </div>

                    <p>{{ $review->comment }}</p>
                    <small>{{ $review->created_at->format('d M, Y') }}</small>
                </div>
            @empty
                <p>No reviews yet. Be the first to review!</p>
            @endforelse
        </div>

        <!-- RIGHT : Write Review -->
        <div class="review-form">
            <div class="review-summary">
                <div class="summary-stars">
                    <span class="avg">
                        {{ $averageRating ?? '0.0' }}
                    </span>
<!-- 
                    <span class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($averageRating))
                                ⭐
                            @else
                                ☆
                            @endif
                        @endfor
                    </span> -->
                </div>

                <p class="summary-text">
                     ({{ $totalReviews }} Reviews)
                </p>
                <p class="summary-stars">Highly Recommended</p>
            </div>
            <h3>Write a Review</h3>

            
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf

                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email (optional)">

                <select name="rating" required>
                    <option value="">Select Rating</option>
                    <option value="1">⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="5">⭐⭐⭐⭐⭐</option>
                </select>

                <textarea name="comment" placeholder="Write your review..." required></textarea>

                <button type="submit">Submit Review</button>
            </form>
        </div>

    </div>
</div>
@endsection
