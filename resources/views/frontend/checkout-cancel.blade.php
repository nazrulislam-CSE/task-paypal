@extends('layouts.frontend', ['pageTitle' => 'Payment Cancelled'])

@section('content')
<div class="container">
    <div class="card my-5">
        <div class="card-header">
            <h4 class="mb-0">Payment Cancelled</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">Your payment for the product "{{ $product->name }}" was cancelled.</h5>
            <p class="card-text">Please try again or choose another payment method.</p>
            <a href="{{ route('product.checkout', ['id' => $product->id]) }}" class="btn btn-primary">Go Back to Checkout</a>
        </div>
    </div>
</div>
@endsection
