<?php

namespace App\Http\Controllers\Client;

use App\Models\MOrderModel;
use App\Models\TOrderModel;
// use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
     public function createSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $total = $request->total;
        $amountInPence = $total * 100;

        $session = StripeSession::create([
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
            'success_url' => route('stripe.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);

        return response()->json(['id' => $session->id]);
    }

    public function success()
    {
        $cart = Session::get('cart', []);
        $finalTotal = Session::get('final_total', 0);
        $orderType = Session::get('order_type', 'delivery');
        $address = Session::get('delivery_address', null);

           Log::info('STRIPE PAYMENT SUCCESS DATA', [
                'cart' => $cart,
                'final_total' => $finalTotal,
                'order_type' => $orderType,
                'delivery_address' => $address,
                'customer_id' => session('customer_id'),
            ]);

        if (empty($cart)) {
            return redirect()->route('orders')->with('error', 'Cart is empty!');
        }

        // 1️⃣ Create Master Order
        $mOrder = MOrderModel::create([
            'customer_id' => session('customer_id'),
            'order_type' => $orderType,
            'delivery_address' => $address,
            'service_charge' => 1,
            'delivery_charge' => $orderType == 'delivery' ? 2 : 0,
            'subtotal' => $finalTotal - 1 - ($orderType == 'delivery' ? 2 : 0),
            'total_amount' => $finalTotal,
            'payment_type' => 'card',
            'payment_status' => 'paid',
            'status' => 'new',
        ]);

        // 2️⃣ Create Order Items
        foreach($cart as $item){

            if (!isset($item['id'])) {
                Log::warning('Cart item missing ID', $item);
                continue; // skip invalid item
            }

            TOrderModel::create([
                'order_id' => $mOrder->id,
                'item_id' => $item['id'],
                'item_name' => $item['name'],
                'quantity' => $item['qty'],
                'unit_price' => $item['basePrice'],
                'total_price' => $item['total'],
                'modifiers' => !empty($item['modifiers']) ? $item['modifiers'] : null
            ]);
        }


        // 3️⃣ Clear Cart Session
        Session::forget('cart');
        Session::forget('final_total');
        Session::forget('order_type');
        Session::forget('delivery_address');

    // 4️⃣ Show success page
        return view('client.payment-success', compact('mOrder'));
    }

    public function cancel()
    {
        return view('client.payment-cancel');
    }
}
