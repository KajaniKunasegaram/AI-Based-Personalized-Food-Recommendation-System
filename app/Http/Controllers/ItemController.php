<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use App\Models\SubCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
   
    public function index()
    {
        $categories = CategoryModel::with(subCategories.items)->get();
        return view('admin.menus.add-update-menus.add-item',compact('categories'));
    }

    public function create($sub_cat_id)
    {
        $subCategory = SubCategoryModel::findOrFail($sub_cat_id);
        return view('admin.menus.add-update-menus.add-item', compact('subCategory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_cat_id' => 'required|exists:tbl_sub_categories,sub_cat_id',
            'item_name' => 'required|string|max:255',
            'item_price' => 'required|numeric',
            'item_description' => 'nullable|string',
            'item_image' => 'nullable|image',
            'item_status' => 'nullable'
        ]);

        $imagePath = null;
        if ($request->hasFile('item_image')) {
            $imagePath = $request->file('item_image')->store('items', 'public');
        }

        ItemModel::create([
            'sub_cat_id' => $request->sub_cat_id,
            'item_name' => $request->item_name,
            'item_price' => $request->item_price,
            'item_description' => $request->item_description,
            'item_image' => $imagePath,
            'item_status' => $request->has('item_status')
        ]);

        return redirect('/admin/menu')->with('success', 'Item added successfully!');
    }

    public function edit($id)
    {
        $item = ItemModel::findOrFail($id);
        return view('admin.menus.add-update-menus.add-item', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = ItemModel::findOrFail($id);

        $data = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_price' => 'required|numeric',
            'item_description' => 'nullable|string',
            'item_image' => 'nullable|image',
            'item_status' => 'nullable'
        ]);

        if ($request->hasFile('item_image')) {
            if ($item->item_image) {
                Storage::disk('public')->delete($item->item_image);
            }
            $data['item_image'] = $request->file('item_image')->store('items', 'public');
        }

        $data['item_status'] = $request->has('item_status');

        $item->update($data);

        return redirect('/admin/menu')->with('success', 'Item updated successfully!');
    }

    public function destroy($id)
    {
        $item = ItemModel::findOrFail($id);

        if ($item->item_image) {
            Storage::disk('public')->delete($item->item_image);
        }

        $item->delete();

        return redirect('/admin/menu')->with('success', 'Item deleted successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $item = ItemModel::findOrFail($id);

        $item->update([
            'item_status' => $request->item_status
        ]);

        return response()->json(['success' => true]);
    }
}
