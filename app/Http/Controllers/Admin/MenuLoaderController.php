<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\ModifierGroupModel;
use App\Models\SubCategoryModel;
use App\Models\ModifierModel;
use App\Models\ItemModel;



class MenuLoaderController extends Controller
{
    public function load($page)
    {
        switch ($page) {

            case 'menus':
                $categories = CategoryModel::all();
                return view('admin.menus.menus', compact('categories'));

            case 'modifier-groups':
                $groups = ModifierGroupModel::all();
                return view('admin.menus.modifier-groups', compact('groups'));

                
            case 'categories':
                $categories = CategoryModel::all();
                return view('admin.menus.categories', compact('categories'));

            case 'sub-categories':
                $subCategories = SubCategoryModel::with('category')->get();
                return view('admin.menus.sub-categories', compact('subCategories'));
  
            case 'items':
                $items = ItemModel::with('subCategory')->get();
                return view('admin.menus.items', compact('items'));

            case 'modifiers':
                $modifiers = ModifierModel::with('group')->get();
                return view('admin.menus.modifiers', compact('modifiers'));
                
            default:
                abort(404);
        }
    }
}
