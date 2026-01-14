<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\DeliveryBoyModel;
use Illuminate\Support\Facades\Session;

class DriverAuthController extends Controller
{
     public function showLoginForm() {
        return view('driver.login');
    }

    public function login(Request $request) {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        $driver = DeliveryBoyModel::where('phone', $request->phone)->first();

        // ✅ Plain password check
        if ($driver && $request->password === $driver->password) {

            // session set
            Session::put('driver_id', $driver->id);
            Session::put('driver_name', $driver->name);

            return redirect('/driver/orders');
        }

        return back()->withErrors(['phone' => 'Invalid phone or password']);
    }

    public function logout() {
        Session::forget(['driver_id', 'driver_name']);
        return redirect('/driver/login');
    }
}
