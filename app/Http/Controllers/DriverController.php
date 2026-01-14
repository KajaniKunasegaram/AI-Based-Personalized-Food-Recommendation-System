<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MOrderModel;
use Illuminate\Support\Facades\Auth;
use App\Models\DeliveryBoyModel; // driver table model

class DriverController extends Controller
{
  public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!session()->has('driver_id')) {
                return redirect('/driver/login');
            }
            return $next($request);
        });
    }

    public function index() {
        $driverId = session('driver_id');
        $orders = \App\Models\MOrderModel::where('delivery_boy_id', $driverId)
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        return view('driver.orders', compact('orders'));
    }

    public function show($id) {
        $driverId = session('driver_id');

        $order = \App\Models\MOrderModel::with('items.modifiers')
                                  ->where('delivery_boy_id', $driverId)
                                  ->where('id', $id)
                                  ->firstOrFail();

        return response()->json($order);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completed,cancelled'
        ]);

        $order = MOrderModel::where('id', $id)
            ->where('delivery_boy_id', session('driver_id'))
            ->firstOrFail();

        $order->status = $request->status;
        $order->save();

        return redirect('/driver/orders');
    }

    public function ordersJson()
    {
        $driverId = session('driver_id');

        $orders = MOrderModel::where('delivery_boy_id', $driverId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }
}
