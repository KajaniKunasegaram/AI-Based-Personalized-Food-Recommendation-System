<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryModel extends Model
{
    use HasFactory;

    protected $table ='tbl_sub_categories';
    protected $primaryKey ='sub_cat_id';

    protected $fillable =['cat_id','sub_cat_name','sub_cat_description','sub_cat_image','sub_cat_status'];

    public function category()
    {
        return $this->belongsTo(\App\Models\CategoryModel::class, 'cat_id','cat_id');
    }

    public function items()
    {
        return $this->hasMany(ItemModel::class, 'sub_cat_id', 'sub_cat_id');
    }
}
