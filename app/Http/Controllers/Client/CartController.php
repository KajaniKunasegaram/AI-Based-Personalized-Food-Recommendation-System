<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $cart = $request->input('cart', []);
        session(['cart' => $cart]); // save to session
        return response()->json(['status' => 'success']);
    }

    
}
