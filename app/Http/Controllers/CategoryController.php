<?php

namespace App\Http\Controllers;
use App\Models\CategoryModel;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {
        return view('admin.menus.add-update-menus.add-category');
    }
        public function index()
    {
        $categories = CategoryModel::orderBy('cat_id','desc')->get();
        return view('admin.menus.menus',compact('categories'));
    }

    public function store(Request $request)
    {
        $validated  =$request->validate([
            'cat_name' => 'required|string|max:255',
            'cat_description' => 'nullable|string',
            'cat_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cat_status' => 'nullable|in:0,1',
        ]);

        $imagePath = null;
        if ($request->hasFile('cat_image')) {
            $file = $request->file('cat_image');
            $imagePath = $file->store('categories', 'public'); 
        }

        $category = CategoryModel::create([
            'cat_name' => $validated['cat_name'],
            'cat_description' => $validated['cat_description'] ?? null,
            'cat_image' => $imagePath,
            'cat_status' => $request->has('cat_status') ? true : false,
        ]);

        return redirect()->back()->with('success','Category added successfully!');
    }
}
