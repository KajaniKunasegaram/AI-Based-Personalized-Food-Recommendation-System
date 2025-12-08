<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CategoryModel extends Model
{
    protected $table ='tbl_categories';
    protected $primaryKey ='cat_id';
    protected $fillable =['cat_name','cat_description','cat_image','cat_status'];
}
