<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryModel;

class DeliveryController extends Controller
{
   // Load page
    public function index()
    {
        $deliveries = DeliveryModel::latest()->get();
        return view('admin.delivery-configuration', compact('deliveries'));
    }

    // Store
    public function store(Request $request)
    {
        $data = $request->validate([
            'postcode' => 'required',
            'delivery_type' => 'required',
            'delivery_charge' => 'nullable'
        ]);

        if ($data['delivery_type'] === 'free') {
            $data['delivery_charge'] = null;
        }

        DeliveryModel::create($data);

        return redirect()->back()->with('success', 'Delivery charge added succesfully!');
    }

    // Fetch single (AJAX)
    public function show($id)
    {
        return response()->json(DeliveryModel::findOrFail($id));
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'postcode' => 'required',
            'delivery_type' => 'required',
            'delivery_charge' => 'nullable'
        ]);

        $delivery = DeliveryModel::findOrFail($id);

        $delivery->update([
            'postcode' => $request->postcode,
            'delivery_type' => $request->delivery_type,
            'delivery_charge' =>
                $request->delivery_type === 'free'
                    ? null
                    : $request->delivery_charge,
        ]);

        return redirect()->back()->with('success', 'Delivery charge updated successfully!');
    }

    // Delete
    public function destroy($id)
    {
        DeliveryModel::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Delivery charge deleted successfully!');
    }
}
