<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOrderModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_torder';

    // protected $primaryKey = 'torder_id';
    
    protected $fillable = [
        'order_id', 'item_id', 'item_name', 'quantity',
        'unit_price', 'total_price', 'modifiers'
    ];

    protected $casts = [
        'modifiers' => 'array', // automatically converts JSON to array
    ];

    // Relationship: Each item belongs to one master order
    public function order()
    {
        return $this->belongsTo(MOrderModel::class, 'order_id');
    }
    //  public function item()
    // {
    //     return $this->belongsTo(ItemModel::class, 'item_id');
    // }
}
