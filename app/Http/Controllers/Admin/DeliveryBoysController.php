<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DeliveryBoysController extends Controller
{
     public function index()
    {
        $deliveryBoys = DB::table('tbl_delivery_boys')->get();
        return view('admin.delivery-boys', compact('deliveryBoys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        DB::table('tbl_delivery_boys')->insert([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Delivery Boy added successfully');
    }

    public function edit($id)
    {
        $boy = DB::table('tbl_delivery_boys')->where('id', $id)->first();
        return response()->json($boy);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        DB::table('tbl_delivery_boys')->where('id', $id)->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Delivery Boy updated successfully');
    }

    public function destroy($id)
    {
        DB::table('tbl_delivery_boys')->where('id', $id)->delete();
        return response()->json(['success' => true]);
    }
}
