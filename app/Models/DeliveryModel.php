<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryModel extends Model
{
    protected $table = 'tbl_delivery';

    protected $fillable = [
        'postcode',
        'delivery_type',
        'delivery_charge'
    ];
}
