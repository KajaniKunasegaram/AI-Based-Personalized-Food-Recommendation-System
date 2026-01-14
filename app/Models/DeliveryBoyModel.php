<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class DeliveryBoyModel extends Model
{
       protected $table = 'tbl_delivery_boys';
    protected $fillable = ['name', 'phone', 'password'];
    protected $hidden = ['password'];
}
