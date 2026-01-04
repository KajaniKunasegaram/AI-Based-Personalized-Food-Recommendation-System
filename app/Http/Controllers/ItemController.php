<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use App\Models\SubCategoryModel;
use App\Models\ModifierGroupModel;
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

        $modifierGroups = ModifierGroupModel::where('status', 1)->get();

        return view('admin.menus.add-update-menus.add-item', compact('subCategory','modifierGroups'));
    }

   

    public function store(Request $request)
    {
        $data = $request->only(['sub_cat_id', 'item_name', 'item_price', 'item_description', 'item_status']);
        
        if ($request->hasFile('item_image')) {
            $path = $request->file('item_image')->store('items', 'public');
            $data['item_image'] = $path;
        }

        $item = ItemModel::create($data);

        // Attach selected modifier groups
        if ($request->has('modifier_group_ids')) {
            $item->modifierGroups()->sync($request->modifier_group_ids);
        }
        return redirect('/admin/menu')->with('success', 'Item added successfully!');

        // return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function update(Request $request, $id)
    {
        $item = ItemModel::findOrFail($id);

        $data = $request->only(['sub_cat_id', 'item_name', 'item_price', 'item_description', 'item_status']);
        
        if ($request->hasFile('item_image')) {
            $path = $request->file('item_image')->store('items', 'public');
            $data['item_image'] = $path;
        }

        $item->update($data);

        // Sync modifier groups
        $item->modifierGroups()->sync($request->modifier_group_ids ?? []);

        return redirect('/admin/menu')->with('success', 'Item updated successfully!');

        // return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }


    public function edit($id)
    {
         $item = ItemModel::with('modifierGroups')->findOrFail($id);

        $modifierGroups = ModifierGroupModel::get();

        return view(
            'admin.menus.add-update-menus.add-item',
            compact('item', 'modifierGroups')
        );
        // $item = ItemModel::findOrFail($id);
        // return view('admin.menus.add-update-menus.add-item', compact('item'));
    }


    public function destroy($id)
    {
        $item = ItemModel::findOrFail($id);

        if ($item->item_image) {
            Storage::disk('public')->delete($item->item_image);
        }
        $item->modifierGroups()->detach(); // pivot clean

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
