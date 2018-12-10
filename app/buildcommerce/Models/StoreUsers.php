<?php

namespace App\buildcommerce\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StoreUsers extends Authenticatable
{
	use Notifiable;

    protected $table="store_users";

    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function feedback()
    {
        return $this->hasMany('App\buildcommerce\Models\Feedback','id','buyer_id');   
    }
}
