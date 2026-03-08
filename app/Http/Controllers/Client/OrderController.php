<?php

namespace App\Http\Controllers\Client;
use App\Models\CategoryModel;
use App\Models\ItemModel;
use App\Models\WebsiteStatusModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 

use App\Services\RecommendationService;

class OrderController extends Controller
{

public function index(RecommendationService $recommendationService)
{
    $categories = CategoryModel::with(['subCategories.items'])
                    ->where('cat_status', 1)
                    ->orderBy('cat_id')
                    ->get();

    $websiteStatus = WebsiteStatusModel::latest()->first();

    Log::info('Fetched Categories', ['count' => $categories->count()]);

    $recommendedItems      = collect();
    $recommendationType    = null;

    $customerId = session('customer_id');

    Log::info('Customer ID from session', ['customer_id' => $customerId]);

    if ($customerId) {

        // Logged in → AI recommendation
        $result = $recommendationService->getRecommendations($customerId);

        $recommendedItemIds  = $result['items'];
        $recommendationType  = $result['type']; 

        Log::info('Recommendations received', [
            'customer_id' => $customerId,
            'type'        => $recommendationType,
            'item_ids'    => $recommendedItemIds,
        ]);

        if ($recommendedItemIds->isNotEmpty()) {

            $recommendedItems = ItemModel::whereIn('item_id', $recommendedItemIds->toArray())
                                ->where('item_status',1)
                                ->get();
        }

    } else {

        // ❗ Logout user → Popular items
        Log::info('Guest user → showing popular items');

        $recommendedItems = ItemModel::select(
                                'tbl_items.item_id',
                                'tbl_items.item_name',
                                'tbl_items.item_price'
                            )
                            ->join('tbl_torder','tbl_items.item_id','=','tbl_torder.item_id')
                            ->join('tbl_morder','tbl_torder.order_id','=','tbl_morder.id')
                            ->groupBy(
                                'tbl_items.item_id',
                                'tbl_items.item_name',
                                'tbl_items.item_price'
                            )
                            ->orderByRaw('COUNT(tbl_torder.item_id) DESC')
                            ->limit(6)
                            ->get();

        $recommendationType = 'popular';
    }

    return view('client.orders', compact(
        'categories',
        'recommendedItems',
        'recommendationType',
        'websiteStatus'
    ));
}



//   public function index(RecommendationService $recommendationService)
//     {
//         $categories = CategoryModel::with(['subCategories.items'])
//                         ->where('cat_status', 1)
//                         ->orderBy('cat_id')
//                         ->get();

//         $websiteStatus = WebsiteStatusModel::latest()->first();

//         Log::info('Fetched Categories', ['count' => $categories->count()]);

//         $recommendedItems      = collect();
//         $recommendationType    = null;   // 'ai' or 'popular'

//         $customerId = session('customer_id');

//         Log::info('Customer ID from session', ['customer_id' => $customerId]);

//         if ($customerId) {
//             $result = $recommendationService->getRecommendations($customerId);

//             // RecommendationService now returns array with 'items' and 'type'
//             $recommendedItemIds  = $result['items'];
//             $recommendationType  = $result['type'];   // 'ai' or 'popular'

//             Log::info('Recommendations received', [
//                 'customer_id' => $customerId,
//                 'type'        => $recommendationType,
//                 'item_ids'    => $recommendedItemIds,
//             ]);

//             if ($recommendedItemIds->isNotEmpty()) {
//                 $recommendedItems = ItemModel::whereIn('item_id', $recommendedItemIds->toArray())->get();
//             }
//         }

//         return view('client.orders', compact('categories', 'recommendedItems', 'recommendationType','websiteStatus'));
//     }



    // public function index(RecommendationService $recommendationService)
    // {
    //     $categories = CategoryModel::with(['subCategories.items'])
    //                     ->where('cat_status', 1)
    //                     ->orderBy('cat_id')
    //                     ->get();

    //     Log::info('Fetched Categories', [
    //         'count' => $categories->count()
    //     ]);

    //     $recommendedItems = collect();
    //     $customerId = session('customer_id');

    //     if ($customerId) {
    //         // Get AI recommended item IDs from Flask
    //         $recommendedItemIds = $recommendationService->getRecommendations($customerId);

    //         Log::info('AI Recommendations', [
    //             'customer_id' => $customerId,
    //             'items' => $recommendedItemIds
    //         ]);

    //         // Fetch full item objects from DB using IDs
    //         if ($recommendedItemIds->isNotEmpty()) {
    //             $recommendedItems = ItemModel::whereIn('item_id', $recommendedItemIds->toArray())->get();
    //         }
    //     }
    //     return view('client.orders', compact('categories', 'recommendedItems'));
    // }



    // public function index(RecommendationService $recommendationService)


    // {

    //     $categories = CategoryModel::with(['subCategories.items'])
//                     ->where('cat_status', 1)
//                     ->orderBy('cat_id')
//                     ->get();

//     Log::info('Fetched Categories', [
//         'count' => $categories->count()
//     ]);

//     $recommendedItems = collect();
//     $customerId = session('customer_id');

//     if ($customerId) {
//         $recommendedItems = $recommendationService->getRecommendations($customerId);

//         Log::info('AI Recommendations', [
//             'customer_id' => $customerId,
//             'items' => $recommendedItems
//         ]);

        
//     }

//     return view('client.orders', compact('categories', 'recommendedItems'));
// }


//   public function index(RecommendationService $recommendationService)
// {
//     $categories = CategoryModel::with(['subCategories.items'])
//                     ->where('cat_status', 1)
//                     ->orderBy('cat_id')
//                     ->get();

         

//     $recommendedItems = collect();
//     $customerId = session('customer_id');

//     if ($customerId) {
//         try {
//             $recommendedItems = $recommendationService->getRecommendedFoods($customerId);

//                     Log::info('Fetched Categories for Orders view', [
//                     'count' => $categories->count(),
//                     'categories' => $categories->toArray(),
//                     'foods' => $recommendedItems->toArray() ,
//                     'cus id '=>$customerId,
//                 ]);
            
//         } catch (\Exception $e) {
//             Log::error('Recommendation Error: ' . $e->getMessage());
//         }
//     }

//     return view('client.orders', compact('categories', 'recommendedItems'));
// }
    public function getItem($id)
    {
        $item = ItemModel::with([
            'modifierGroups' => function ($q) {
                $q->where('status', 1)
                ->whereHas('modifiers');
            },
            'modifierGroups.modifiers'
        ])->findOrFail($id);

        return response()->json($item);
    }
}
