<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModifierModel;

class ModifierController extends Controller
{
    public function index()
    {
        $modifiers = ModifierModel::with('modifiers')->get();
        return view('admin.menus.modifiers', compact('modifiers'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:tbl_modifiers_group,id',
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'min' => 'nullable|integer|min:0',
            'max' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        ModifierModel::create([
            'modifier_group_id' => $request->group_id,
            'name' => $request->name,
            'price' => $request->price ?? 0,
            'min' => $request->min ?? 0,
            'max' => $request->max ?? 0,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return back()->with('success', 'Modifier added successfully!');
    }

    public function update(Request $request, $id)
    {
        $modifier = ModifierModel::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'min' => 'nullable|integer|min:0',
            'max' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        $modifier->update([
            'name' => $request->name,
            'price' => $request->price ?? 0,
            'min' => $request->min ?? 0,
            'max' => $request->max ?? 0,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return back()->with('success', 'Modifier updated successfully!');
    }

    public function destroy($id)
    {
        ModifierModel::findOrFail($id)->delete();
        return back()->with('success', 'Modifier deleted successfully!');
    }
}
