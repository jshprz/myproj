<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\buildcommerce\Repository\StoreRepositoryInterface;
use App\buildcommerce\Repository\UserRepositoryInterface;

class UserController extends Controller
{
	public function __construct(StoreRepositoryInterface $store, UserRepositoryInterface $user)
    {
        $this->store = $store;
        $this->user = $user;
    }
    
    public function genQrCode(Request $request)
    {
        return $this->store->genQrCode($request);
    }          
}
