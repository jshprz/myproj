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
    public function index($storeName)
    {
        $data = $this->store->getStoreByName($storeName);
        if($data)
        {
            return view('checkout.checkout',compact('storeName', 'data'));
        }
        else
        {
            return view('error-page.404');
        }
    }
}
