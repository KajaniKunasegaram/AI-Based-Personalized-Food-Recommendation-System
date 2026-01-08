<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
     public function index()
    {
        $totalOrders = DB::table('tbl_morder')->count();
        $completedOrders = DB::table('tbl_morder')->where('status', 'completed')->count();
        $cancelledOrders = DB::table('tbl_morder')->where('status', 'cancelled')->count();
        $totalCustomers = DB::table('tbl_customer')->count();

        $todayRevenue = DB::table('tbl_morder')
            ->whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $avgRating = DB::table('tbl_reviews')->avg('rating');

        $recentOrders = DB::table('tbl_morder')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'completedOrders',
            'cancelledOrders',
            'totalCustomers',
            'todayRevenue',
            'avgRating',
            'recentOrders'
        ));
    }
}
