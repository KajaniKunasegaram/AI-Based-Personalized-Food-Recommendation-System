<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CategoryModel extends Model
{
    protected $table ='tbl_categories';
    protected $primaryKey ='cat_id';
    protected $fillable =['cat_name','cat_description','cat_image','cat_status'];

    
    // Relationship to SubCategory
    public function subCategories()
    {
        return $this->hasMany(
            SubCategoryModel::class, // your subcategory model
            'cat_id',                // foreign key in subcategories table
            'cat_id'                 // local key in categories table
        );
    }
}
