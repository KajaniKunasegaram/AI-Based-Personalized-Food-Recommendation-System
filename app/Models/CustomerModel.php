<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerModel extends Model
{
     use HasFactory;

    protected $table = 'tbl_customer';

    protected $fillable = [
         'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
