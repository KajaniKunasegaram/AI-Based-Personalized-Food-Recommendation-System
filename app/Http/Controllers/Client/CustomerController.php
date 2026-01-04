<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Hash;


class CustomerController extends Controller
{
     // Show registration form
    public function showRegister()
    {
        return view('client.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tbl_customer,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        CustomerModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    // Show login form
    public function showLogin()
    {
        return view('client.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = CustomerModel::where('email', $request->email)->first();

        if ($customer && Hash::check($request->password, $customer->password)) {
            // Store customer in session
            $request->session()->put('customer_id', $customer->id);
            $request->session()->put('customer_name', $customer->name);

            return redirect()->route('checkout');
        } else {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    // Handle logout
    public function logout(Request $request)
    {
        $request->session()->forget(['customer_id', 'customer_name']);
        return redirect()->route('login');
    }
}
