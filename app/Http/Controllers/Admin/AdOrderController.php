<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MOrderModel;

use Illuminate\Http\Request;

class AdOrderController extends Controller
{
     public function index()
    {
        $orders = MOrderModel::orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
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
}
