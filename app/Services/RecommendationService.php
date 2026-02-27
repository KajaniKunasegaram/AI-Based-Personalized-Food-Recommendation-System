<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecommendationService
{

    public function getRecommendations(string $customerId): array
    {
        $empty = [
            'items' => collect(),
            'type'  => null,
        ];

        try {
            $response = Http::timeout(10)
                ->post('http://127.0.0.1:5000/api/recommend', [
                    'customer_id' => $customerId,
                ]);

            $data = $response->json();

            Log::info('Flask API Response', $data);

            if (isset($data['status']) && $data['status'] === 'success') {
                return [
                    'items' => collect($data['recommendations'] ?? []),
                    'type'  => $data['type'] ?? 'popular',  // 'ai' or 'popular'
                ];
            }

            Log::error('Python API Error', $data);
            return $empty;

        } catch (\Exception $e) {
            Log::error('RecommendationService Exception', ['message' => $e->getMessage()]);
            return $empty;
        }
    }
    

//  public function getRecommendations($customerId)
//     {
//         try {

//             $response = Http::post('http://127.0.0.1:5000/api/recommend', [
//                 'customer_id' => $customerId
//             ]);

//             if ($response->successful()) {
//                 return collect($response->json()['recommendations']);
//             }

//             Log::error('Python API Error: ' . $response->body());
//             return collect();

//         } catch (\Exception $e) {

//             Log::error('Connection Error: ' . $e->getMessage());
//             return collect();
//         }
//     }

    // public function getRecommendedFoods($customerId)
    // {
    //     try {

    //         $response = Http::post('http://127.0.0.1:5000/api/recommend', [
    //             'customer_id' => $customerId
    //         ]);

    //         if ($response->successful()) {

    //             $data = $response->json();

    //             if ($data['status'] === 'success') {
    //                 return collect($data['recommendations']);
    //             }
    //         }

    //         return collect();

    //     } catch (\Exception $e) {
    //         Log::error('Flask API Error: ' . $e->getMessage());
    //         return collect();
    //     }
    // }
}