<?php

namespace App\buildcommerce\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'store';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function product()
    {
        return $this->hasMany('App\buildcommerce\Models\Products');
    }

    public function productCategory()
    {
        return $this->hasMany('App\buildcommerce\Models\ProductCategory');
    }
}
