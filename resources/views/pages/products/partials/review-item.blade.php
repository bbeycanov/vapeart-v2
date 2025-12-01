<div class="product-single__reviews-item">
    <div class="customer-avatar">
        <img loading="lazy" src="{{ asset('storefront/images/avatar.jpg') }}" alt="{{ $review->author_name }}">
    </div>
    <div class="customer-review">
        <div class="customer-name">
            <h6>{{ $review->author_name ?: 'Anonymous' }}</h6>
            <div class="reviews-group d-flex">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="review-star {{ $i <= $review->rating ? 'active' : '' }}" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_star" />
                    </svg>
                @endfor
            </div>
        </div>
        <div class="review-date">{{ $review->created_at->format('F d, Y') }}</div>
        @if($review->title)
            <div class="review-title">
                <strong>{{ $review->title }}</strong>
            </div>
        @endif
        @if($review->body)
            <div class="review-text">
                <p>{{ $review->body }}</p>
            </div>
        @endif
    </div>
</div>

