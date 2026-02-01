<?php

namespace App\Http\Controllers\Client;
use App\Models\CategoryModel;
use App\Models\ItemModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 

class OrderController extends Controller
{
    public function index()
    {
        $categories = CategoryModel::with(['subCategories.items'])
            ->where('cat_status', 1)
            ->orderBy('cat_id')
            ->get();
                $recommendedItems = [];

                    if (auth()->check()) {
                        Log::info('User is logged in: ' . auth()->user()->id);
                        
                        try {
                            $userId = session('customer_id') ?? auth()->user()->customer_id;
                            Log::info('Checking AI for Customer ID: ' . $userId);

                            // Rest of your code...
                        } catch (\Exception $e) {
                            Log::error('AI Error: ' . $e->getMessage());
                        }
                    } else {
                        Log::warning('User NOT logged in. Skipping AI.');
                    }

        return view('client.orders', compact('categories','recommendedItems'));
    }

    public function getItem($id)
{
    $item = ItemModel::with([
        'modifierGroups' => function ($q) {
            $q->where('status', 1)              // ✅ modifier group active
              ->whereHas('modifiers');          // ✅ modifiers empty இல்லாத group மட்டும்
        },
        'modifierGroups.modifiers'
    ])->findOrFail($id);

    return response()->json($item);
}

//     public function getItem($id)
// {
//     $item = ItemModel::with([
//         'modifierGroups' => function ($q) {
//             $q->whereHas('modifiers'); 
//         },
//         'modifierGroups.modifiers'
//     ])->findOrFail($id);

//     return response()->json($item);
// }
//     public function getItem($id)
// {
//     $item = ItemModel::with([
//         'modifierGroups.modifiers'
//     ])->findOrFail($id);

//     return response()->json($item);
// }
}
