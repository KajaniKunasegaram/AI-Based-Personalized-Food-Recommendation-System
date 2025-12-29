<?php

namespace App\Http\Controllers;

use App\Models\SubCategoryModel; 
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategoryModel::with('category')->orderBy('sub_cat_id','desc')->get();
        return view('admin.menus.add-update-menus.add-subcategory', compact('subCategories'));
    }

    public function create($cat_id = null)
    {
        $categories = CategoryModel::where('cat_status', 1)->get();
        return view('admin.menus.add-update-menus.add-subcategory', [
            'categories' => $categories,
            'selectedCategory' => $cat_id
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cat_id' => 'required|exists:tbl_categories,cat_id',
            'sub_cat_name' => 'required|string|max:255',
            'sub_cat_description' => 'nullable|string',
            'sub_cat_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sub_cat_status' => 'nullable|boolean',
        ]);

        $imagePath = $request->hasFile('sub_cat_image') 
            ? $request->file('sub_cat_image')->store('sub-categories', 'public') 
            : null;

        SubCategoryModel::create([
            'cat_id' => $request->cat_id,
            'sub_cat_name' => $request->sub_cat_name,
            'sub_cat_description' => $request->sub_cat_description,
            'sub_cat_image' => $imagePath,
            'sub_cat_status' => $request->has('sub_cat_status') ? 1 : 0,
        ]);

        return redirect('/admin/menu')->with('success', 'SubCategory added successfully!');
    }

    public function edit($id)
    {
        $subCategory = SubCategoryModel::findOrFail($id);
        $categories = CategoryModel::where('cat_status', 1)->get();
        $selectedCategory = $subCategory->cat_id;

        return view('admin.menus.add-update-menus.add-subcategory', compact('subCategory','categories','selectedCategory'));
    }

    public function update(Request $request, $id)
    {
        $subCategory = SubCategoryModel::findOrFail($id);

        $request->validate([
            'cat_id' => 'required|exists:tbl_categories,cat_id',
            'sub_cat_name' => 'required|string|max:255',
            'sub_cat_description' => 'nullable|string',
            'sub_cat_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sub_cat_status' => 'nullable|boolean',
        ]);

        $data = $request->only(['cat_id', 'sub_cat_name', 'sub_cat_description']);
        $data['sub_cat_status'] = $request->has('sub_cat_status') ? 1 : 0;

        if ($request->hasFile('sub_cat_image')) {
            if ($subCategory->sub_cat_image) {
                Storage::disk('public')->delete($subCategory->sub_cat_image);
            }
            $data['sub_cat_image'] = $request->file('sub_cat_image')->store('sub-categories', 'public');
        }

        $subCategory->update($data);

        return redirect('/admin/menu')->with('success', 'SubCategory updated successfully!');
    }

    public function destroy($id)
    {
        $subCategory = SubCategoryModel::findOrFail($id);

        if ($subCategory->sub_cat_image) {
            Storage::disk('public')->delete($subCategory->sub_cat_image);
        }

        $subCategory->delete();
        return redirect('/admin/menu')->with('success', 'SubCategory deleted successfully!');
    }
}
