<?php

namespace App\buildcommerce\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public function productCategory()
    {
       return $this->hasMany('App\buildcommerce\Models\ProductCategory');
    }   
}
