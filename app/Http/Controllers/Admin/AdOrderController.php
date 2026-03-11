<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MOrderModel;
use App\Models\DeliveryBoyModel;


use Illuminate\Http\Request;

class AdOrderController extends Controller
{
     public function index()
    {
        $orders = MOrderModel::orderBy('created_at', 'desc')->get();
         $drivers = DeliveryBoyModel::all();
        return view('admin.orders', compact('orders','drivers'));
    }

    public function show($id)
    {
        $order = MOrderModel::with('items')->findOrFail($id);
        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = MOrderModel::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true]);
    }


   

    public function assignDriver(Request $request, $id)
    {
        $request->validate([
            'delivery_boy_id' => 'required|exists:tbl_delivery_boys,id'
        ]);

        $order = MOrderModel::findOrFail($id);

        $order->delivery_boy_id = $request->delivery_boy_id;
        $order->status = 'on_the_way'; // optional but recommended
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Driver assigned'
        ]);
    }

    public function pollOrders(Request $request)
    {
        $status = $request->get('status', 'new');
        
        $orders = MOrderModel::with('items')
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }
    

}
