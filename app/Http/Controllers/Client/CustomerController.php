<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class CustomerController extends Controller
{
    public function register(Request $request)
    {
        // Validate form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:tbl_customer,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create customer
        CustomerModel::create([
            'id' => hash('sha256', Str::uuid()), // 🔥 HASH ID
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // encrypt password
        ]);

        // Redirect after registration
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if user exists
        $user = CustomerModel::where('email', $request->email)->first();

       if($user && Hash::check($request->password, $user->password)){
            // Login success: store user info in session
            session([
                'customer_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email
            ]);

            // Redirect to More page
            // Redirect to intended page or default
            if ($request->has('redirect') && $request->redirect == 'checkout') {
                return redirect()->route('checkout');
            }

            return redirect()->route('more'); // normal login redirect
        }else {
            // Login failed
            return back()->withErrors(['Invalid email or password'])->withInput();
        }
    }

    public function deleteAccount(Request $request)
    {
        // Check if customer is logged in
        $customerId = session('customer_id');
        if(!$customerId){
            return redirect()->route('login');
        }

        // Delete customer from database
        CustomerModel::where('id', $customerId)->delete();

        // Clear session
        $request->session()->flush(); // removes all session data

        // Redirect to login page with a message
        return redirect()->route('login')->with('success', 'Your account has been deleted.');
    }

    public function logout(Request $request)
    {
        // Clear all session data
        $request->session()->flush();

        // Redirect to login page with optional message
        return redirect()->route('login');
    }

}
