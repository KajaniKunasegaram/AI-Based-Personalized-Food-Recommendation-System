<?php

namespace App\Http\Controllers\Client;
use App\Models\CategoryModel;
use App\Models\ItemModel;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $categories = CategoryModel::with(['subCategories.items'])
            ->where('cat_status', 1)
            ->orderBy('cat_id')
            ->get();

        return view('client.orders', compact('categories'));
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
