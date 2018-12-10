<?php

namespace App\buildcommerce\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    public function storeUser()
    {
        return $this->belongsTo('App\buildcommerce\Models\StoreUsers','buyer_id','id');
    }
}
