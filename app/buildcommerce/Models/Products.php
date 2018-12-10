<?php

namespace App\buildcommerce\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    public function store()
    {
        return $this->belongsTo('App\buildcommerce\Models\Store');
    }
    
    public function productCategory()
    {
        return $this->belongsTo('App\buildcommerce\Models\ProductCategory');
    }

    public function transaction()
    {
        return $this->belongsTo('App\buildcommerce\Models\Transactions','product_id');
    }
}
