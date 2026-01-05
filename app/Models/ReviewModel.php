<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewModel extends Model
{
       protected $table = 'tbl_reviews'; // 👈 IMPORTANT

    protected $fillable = [
        'name',
        'email',
        'rating',
        'comment'
    ];

}
