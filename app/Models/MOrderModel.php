<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MOrderModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_morder';

    protected $fillable = [
        'customer_id', 'order_type', 'delivery_address',
        'service_charge', 'delivery_charge', 'subtotal',
        'total_amount', 'payment_type', 'payment_status', 'status'
    ];

    // Relationship: One master order has many items
    public function items()
    {
        return $this->hasMany(TOrderModel::class, 'order_id');
    }
}
