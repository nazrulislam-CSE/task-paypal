@extends('layouts.frontend', ['pageTitle' => 'Checkout'])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-5">
        <!-- Product Details -->
        <div class="col-md-6">
            <div class="card">
                <img class="card-img-top" src="{{ asset($product->image) }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Checkout</h5>
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf

                        <!-- Hidden Product ID Field -->
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Payment Options -->
                        <div class="form-group mb-3">
                            <label for="payment_method">Payment Method</label>
                            <select class="form-control" name="payment_method" id="payment_method" required>
                                <option value="paypal">PayPal</option>
                                <option value="cash_on_delivery">Cash on Delivery</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
