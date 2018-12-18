<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\buildcommerce\Repository\StoreRepositoryInterface;

class CheckoutController extends Controller
{
    public function __construct(StoreRepositoryInterface $store)
    {
        $this->store = $store; 
    }
    public function index()
    {
        $private_ip = $request->server('SERVER_ADDR');
        $data = $this->store->getStoreByPrivateIp($private_ip);
        if($data)
        {
            return view('checkout.checkout',compact('data'));
        }
        else
        {
            return view('error-page.404');
        }
    }
}
