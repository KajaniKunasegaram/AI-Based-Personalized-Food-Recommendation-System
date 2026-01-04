<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
     public function createSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $total = $request->total;
        $amountInPence = $total * 100;

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => 'Order Payment',
                    ],
                    'unit_amount' => $amountInPence,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);

        return response()->json(['id' => $session->id]);
    }

    public function success()
    {
        return view('client.payment-success');
    }

    public function cancel()
    {
        return view('client.payment-cancel');
    }
}
