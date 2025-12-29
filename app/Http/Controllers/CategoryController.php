<?php

namespace App\Http\Controllers;
use App\Models\CategoryModel;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {
        return view('admin.menus.add-update-menus.add-category');
    }
   
    public function menus()
    {
        $categories = CategoryModel::orderBy('cat_id','desc')->get();
        return view('admin.menu', compact('categories'));
    }
    public function index()
    {
         $categories = CategoryModel::with('subCategories.items')
        ->orderBy('cat_id', 'desc')
        ->get();

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
        return redirect('/admin/menu')->with('success', 'Category added successfully!');
    }

    public function edit($id)
    {
        $category = CategoryModel::findOrFail($id);
        return view('admin.menus.add-update-menus.add-category', compact('category'));
    }

    
    /* UPDATE */
    public function update(Request $request, $id)
    {
        $category = CategoryModel::findOrFail($id);

        $data = $request->validate([
            'cat_name' => 'required|string|max:255',
            'cat_description' => 'nullable|string',
            'cat_image' => 'nullable|image',
            'cat_status' => 'nullable'
        ]);

        if ($request->hasFile('cat_image')) {
            // delete old image
            if ($category->cat_image) {
                Storage::disk('public')->delete($category->cat_image);
            }
            $data['cat_image'] = $request->file('cat_image')
                ->store('categories', 'public');
        }

        $data['cat_status'] = $request->has('cat_status');

        $category->update($data);
        return redirect('/admin/menu')->with('success', 'Category updated successfully!');

    }

    /* DELETE */
    public function destroy($id)
    {
        $category = CategoryModel::findOrFail($id);

        if ($category->cat_image) {
            Storage::disk('public')->delete($category->cat_image);
        }
        $category->delete();

        // 🔁 admin/menu page ku redirect
        return redirect('/admin/menu')
        ->with('success', 'Category deleted successfully!');
    }
}
