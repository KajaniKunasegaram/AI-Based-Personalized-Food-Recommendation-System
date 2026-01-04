<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    protected $table = 'tbl_items';
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'sub_cat_id',
        'item_name',
        'item_description',
        'item_price',
        'item_image',
        'item_status'
    ];

    
    public function subCategory()
    {
        return $this->belongsTo(SubCategoryModel::class, 'sub_cat_id', 'sub_cat_id');
    }



    public function modifierGroups()
    {
        return $this->belongsToMany(
            ModifierGroupModel::class,
            'tbl_item_modifier_group',
            'item_id',
            'modifier_group_id'
        );
    }
}
