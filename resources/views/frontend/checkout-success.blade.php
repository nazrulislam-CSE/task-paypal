@extends('layouts.frontend', ['pageTitle' => 'Payment Success'])

@section('content')
<div class="container">
    <div class="card my-5">
        <div class="card-header">
            <h4 class="mb-0">Payment Successful</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">Your payment for the product "{{ $product->name }}" has been completed successfully.</h5>
            <p class="card-text">Thank you for your purchase! You can go back to your homepage to view your order details.</p>
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Go to Homepage</a>
        </div>
    </div>
</div>
@endsection
