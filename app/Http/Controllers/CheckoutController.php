<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Auth;
use Srmklive\PayPal\Services\PayPal;

class CheckoutController extends Controller
{
    public function checkout($id)
    {
        $product = Product::findOrFail($id);
        return view('frontend.checkout', compact('product'));
    }


    public function processCheckout(Request $request)
    {
        // Retrieve the product by ID
        $product = Product::findOrFail($request->input('product_id'));
    
        // Handle payment processing logic based on selected method
        if ($request->payment_method == 'paypal') {

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $paymentAmount = $product->price;
            $currency = 'USD'; 
    
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.success'),
                    "cancel_url" => route('paypal.cancel'),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => $currency,
                            "value" => number_format($paymentAmount, 2, '.', ''),
                        ]
                    ]
                ]
            ]);
    
            // Check if 'id' exists in the response array
            if (isset($response['id']) && !empty($response['id'])) {
                // Loop through the links in the response and find the approve link
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }

                // If no approve link found, redirect to the cancel route with error
                return redirect()->route('cancel.payment')->with('error', 'Something went wrong.');
            } else {
                
                // Redirect back with a generic error message
                return redirect()->back()->with('error', 'Something went wrong, please try again.');
            }
        }
    
        // Handle Cash on Delivery logic
        if ($request->payment_method == 'cash_on_delivery') {
            // Process Cash on Delivery and complete the order
    
            // Insert the order into the database
            $order = Order::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
                'amount' => $product->price,
                'payment_status' => 'pending', // Cash on delivery is 'pending'
            ]);
    
            // Redirect to success page
            return redirect()->route('order.success')->with('success', 'Order placed successfully.');
        }
    
        return redirect()->back()->with('error', 'Invalid payment method.');
    }
    

    // PayPal Success Route
    public function success(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Process the payment success logic
        // You might want to store the transaction info in the database or send a confirmation email

        return view('frontend.checkout-success', compact('product'));
    }

    // PayPal Cancel Route
    public function cancel(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Handle payment cancel scenario
        return view('frontend.checkout-cancel', compact('product'));
    }

    // order success
    public function successOrder()
    {
        return view('frontend.order-success');
    }


}

