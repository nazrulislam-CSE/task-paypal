@extends('layouts.frontend', ['pageTitle' => 'User Dashboard'])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Examples -->
    <div class="row mb-5">
        @foreach($products as $product)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <!-- Display product image -->
                    <img class="card-img-top" src="{{ asset($product->image) }}" alt="Card image cap" />
                    <div class="card-body">
                        <!-- Display product name -->
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <!-- Display product description -->
                        <p class="card-text">{{ $product->description }}</p>
                        <!-- Display buy button and price -->
                        <a href="{{ route('product.checkout', $product->id) }}" class="btn btn-outline-primary">
                            <i class="tf-icons bx bx-cart-alt me-1"></i>Buy Now
                        </a>
                        <span style="float: right; font-size: 20px; font-weight: 700;">
                            ${{ number_format($product->price, 2) }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('frontend-js')
<script>
    // Add any specific JS code you might need here
</script>
@endpush
