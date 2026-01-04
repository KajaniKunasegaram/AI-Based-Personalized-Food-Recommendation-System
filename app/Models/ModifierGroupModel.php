<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModifierGroupModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_modifiers_group';

    protected $fillable = [
        'group_name',
        'min_select',
        'max_select',
        'status'
    ];

    public function modifiers()
    {
        return $this->hasMany(ModifierModel::class, 'modifier_group_id');
    }


    public function items()
    {
        return $this->belongsToMany(
            ItemModel::class,
            'tbl_item_modifier_group',
            'modifier_group_id',
            'item_id'
        );
    }
}
