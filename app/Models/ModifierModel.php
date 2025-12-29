<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModifierModel extends Model
{
    protected $table = 'tbl_modifiers';

    protected $fillable = [
        'modifier_group_id',
        'name',
        'price',
        'min',
        'max',
        'status'
    ];

    public function group()
    {
        return $this->belongsTo(ModifierGroupModel::class, 'modifier_group_id');
    }
}
