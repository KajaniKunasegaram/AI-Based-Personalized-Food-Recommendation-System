<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Hash;


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
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // encrypt password
        ]);

        // Redirect after registration
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
}
