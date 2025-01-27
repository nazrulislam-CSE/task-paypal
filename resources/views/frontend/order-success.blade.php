@extends('layouts.frontend', ['pageTitle' => 'Order Success'])

@section('content')
<div class="container">
    <div class="card my-5">
        <div class="card-header">
            <h4 class="mb-0">Order Success</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">Order Placed Successfully!</h5>
            <p class="card-text">Your order has been placed successfully. You will pay on delivery.</p>
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Go to Homepage</a>
        </div>
    </div>
</div>
@endsection
