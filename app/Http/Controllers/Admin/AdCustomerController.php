<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerModel;
use Illuminate\Http\Request;

class AdCustomerController extends Controller
{
    public function index()
    {
        $customers = CustomerModel::latest()->get();
        return view('admin.customers', compact('customers'));
    }
}
