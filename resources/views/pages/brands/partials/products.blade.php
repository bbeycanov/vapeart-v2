@foreach($products as $product)
    <div class="col mb-3 mb-md-4 mb-xxl-5">
        <x-product-card :product="$product" />
    </div>
@endforeach

