<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModifierGroupModel;

class ModifierGroupController extends Controller
{
    // Show main listing view
    public function index()
    {
        $groups = ModifierGroupModel::with('modifiers')->get();
        return view('admin.menus.modifier-groups', compact('groups'));
    }

    // Show add form
    public function create()
    {
        return view('admin.menus.add-update-menus.add-modifier-group', [
            'mode' => 'add'
        ]);
    }

    // Store new group
    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'min_select' => 'nullable|integer|min:0',
            'max_select' => 'nullable|integer|min:0',
        ]);

        ModifierGroupModel::create([
            'group_name' => $request->group_name,
            'min_select' => $request->min_select ?? 0,
            'max_select' => $request->max_select ?? 0,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        // Redirect to main listing page
        return redirect('/admin/menu?tab=modifier-groups')
        ->with('success', 'Modifier group added successfully');

        // return redirect()->route('modifier-groups.index')
        //                  ->with('success', 'Modifier group added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $group = ModifierGroupModel::with('modifiers')->findOrFail($id);
        return view('admin.menus.add-update-menus.add-modifier-group', [
            'mode' => 'edit',
            'group' => $group,
            'modifiers' => $group->modifiers
        ]);
    }

    // Update existing group
    public function update(Request $request, $id)
    {
        $group = ModifierGroupModel::findOrFail($id);

        $request->validate([
            'group_name' => 'required|string|max:255',
            'min_select' => 'nullable|integer|min:0',
            'max_select' => 'nullable|integer|min:0',
        ]);

        $group->update([
            'group_name' => $request->group_name,
            'min_select' => $request->min_select ?? 0,
            'max_select' => $request->max_select ?? 0,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect('/admin/menu?tab=modifier-groups')
                         ->with('success', 'Modifier group updated successfully!');
    }

    // Delete group and its modifiers
    public function destroy($id)
    {
        $group = ModifierGroupModel::findOrFail($id);
        $group->modifiers()->delete(); // delete all associated modifiers
        $group->delete();

        return redirect('/admin/menu?tab=modifier-groups')
                         ->with('success', 'Modifier group deleted successfully!');
    }
}
