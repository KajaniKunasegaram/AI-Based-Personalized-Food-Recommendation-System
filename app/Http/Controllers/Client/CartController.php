<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{   

    public function view()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum('total');

        return view('client.checkout', compact('cart', 'total'));
    }

    public function save(Request $request)
    {
         Log::info('CART RECEIVED IN SAVE()', $request->cart);
        session([
            'cart' => $request->cart,
            'final_total' => $request->final_total,
            'order_type' => $request->order_type,
            'delivery_address' => $request->delivery_address,
        ]);

        return response()->json(['status' => 'saved']);
    }


    // public function save(Request $request)
    // {
    //     $cart = $request->input('cart', []);
    //     session(['cart' => $cart]); // save to session
    //     return response()->json(['status' => 'success']);
    // }

    public function deleteItem(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->index]);

        session()->put('cart', array_values($cart));
        return response()->json(['success' => true]);
    }

    public function deleteModifier(Request $request)
    {
        $cart = session()->get('cart', []);

        unset($cart[$request->itemIndex]['modifiers'][$request->modifierIndex]);

        // reindex modifiers
        $cart[$request->itemIndex]['modifiers'] =
            array_values($cart[$request->itemIndex]['modifiers']);

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function updateQty(Request $request)
    {
        $cart = session()->get('cart', []);

        $index = $request->index;
        $newQty = max(1, (int) $request->qty);

        $oldQty = $cart[$index]['qty'];
        $oldTotal = $cart[$index]['total'];

        $unitPrice = $oldTotal / $oldQty;

        $cart[$index]['qty'] = $newQty;
        $cart[$index]['total'] = $unitPrice * $newQty;

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }
    
}
