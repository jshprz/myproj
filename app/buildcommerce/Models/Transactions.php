<?php

namespace App\buildcommerce\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = "transactions";

    protected $fillable = [
    	'buyer_id','product_id','order_id','total_paid','payment_courier','quantity','status'
    ];

    public function product()
    {
        return $this->hasMany('App\buildcommerce\Models\Products','id');
    }
}
