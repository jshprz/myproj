<?php

namespace App\buildcommerce\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_category';

    public function category()
    {
        return $this->belongsTo('App\buildcommerce\Models\Category');
    }

    public function store()
    {
        return $this->belongsTo('App\buildcommerce\Models\Store');
    }

    public function product()
    {
        return $this->hasMany('App\buildcommerce\Models\Products','product_category_id');
    }

    public function getProductCategoryByName($categoryName)
    {
        return $this->where('category_name',$categoryName)->first();
    }
}
