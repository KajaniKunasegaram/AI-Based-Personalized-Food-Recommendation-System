@extends('client.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/client/reviews.css') }}">

<div class="reviews-page">

    <!-- HERO HEADER -->
    <div class="reviews-hero">
        <div class="hero-left">
            <div class="hero-label">WHAT PEOPLE SAY</div>
            <h1 class="hero-title">Customer<br><em>Reviews</em></h1>
        </div>
        <div class="hero-right">
            <div class="rating-display">
                <div class="rating-number">{{ $averageRating ?? '0.0' }}</div>
                <div class="rating-meta">
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-{{ $i <= floor($averageRating ?? 0) ? 'solid' : 'regular' }} fa-star"></i>
                        @endfor
                    </div>
                    <div class="rating-count">{{ $totalReviews }} Reviews</div>
                    <div class="rating-tag">Highly Recommended</div>
                </div>
            </div>
            <a href="{{ route('orders') }}" class="order-btn">
                <i class="fa-solid fa-utensils"></i> Order Now
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="success-msg" id="successMsg">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- GRID -->
    <div class="reviews-grid">

        <!-- LEFT: Reviews List -->
        <div class="reviews-list">
            <div class="section-label">ALL REVIEWS</div>

            @forelse($reviews as $review)
                <div class="review-card">
                    <div class="review-top">
                        <div class="reviewer-avatar">
                            {{ strtoupper(substr($review->name, 0, 1)) }}
                        </div>
                        <div class="reviewer-info">
                            <strong class="reviewer-name">{{ $review->name }}</strong>
                            <div class="review-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="review-date">
                            {{ $review->created_at->format('d M, Y') }}
                        </div>
                    </div>
                    <p class="review-comment">{{ $review->comment }}</p>
                </div>
            @empty
                <div class="empty-reviews">
                    <i class="fa-regular fa-comment-dots"></i>
                    <p>No reviews yet. Be the first to share your experience!</p>
                </div>
            @endforelse
        </div>

        <!-- RIGHT: Write Review Form -->
        <div class="review-form-wrap">
            <div class="form-card">
                <div class="section-label">SHARE YOUR EXPERIENCE</div>
                <h2 class="form-title">Write a<br><em>Review</em></h2>

                <form action="{{ route('reviews.store') }}" method="POST" class="review-form">
                    @csrf

                    <div class="field-group">
                        <input type="text" name="name" id="r-name" placeholder=" " required>
                        <label for="r-name">Your Name</label>
                        <div class="field-line"></div>
                    </div>

                    <div class="field-group">
                        <input type="email" name="email" id="r-email" placeholder=" ">
                        <label for="r-email">Email Address (optional)</label>
                        <div class="field-line"></div>
                    </div>

                    <div class="field-group select-group">
                        <select name="rating" id="r-rating" required>
                            <option value="" disabled selected></option>
                            <option value="1">⭐ — Poor</option>
                            <option value="2">⭐⭐ — Fair</option>
                            <option value="3">⭐⭐⭐ — Good</option>
                            <option value="4">⭐⭐⭐⭐ — Great</option>
                            <option value="5">⭐⭐⭐⭐⭐ — Excellent</option>
                        </select>
                        <label for="r-rating">Your Rating</label>
                        <div class="field-line"></div>
                    </div>

                    <div class="field-group">
                        <textarea name="comment" id="r-comment" placeholder=" " required></textarea>
                        <label for="r-comment">Your Review</label>
                        <div class="field-line"></div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <span>Submit Review</span>
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const msg = document.getElementById('successMsg');
        if (msg) {
            setTimeout(() => {
                msg.style.opacity = '0';
                msg.style.transition = 'opacity 0.5s ease';
                setTimeout(() => msg.remove(), 500);
            }, 3000);
        }
    });
</script>

@endsection