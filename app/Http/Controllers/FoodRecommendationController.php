<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FoodRecommendationController extends Controller
{
   public function getSuggestions(Request $request)
    {
        $userId = $request->user_id; // Get ID from your web form

        // Laravel calling the Python Bridge
        $response = Http::post('http://127.0.0.1:5000/api/recommend', [
            'customer_id' => $userId
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return view('recommendations', ['foods' => $data['recommendations']]);
        }

        return back()->with('error', 'Could not connect to ML service.');
    }
}
