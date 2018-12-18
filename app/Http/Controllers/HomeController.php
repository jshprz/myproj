<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\buildcommerce\Repository\StoreRepositoryInterface;

class HomeController extends Controller
{
    protected $store;
    
    public function __contruct(StoreRepositoryInterface $store)
    {
        $this->store = $store;
    }

    public function index(Request $request)
    {
        $private_ip = $request->server('SERVER_ADDR');
        $data = $this->store->getStoreByPrivateIp($private_ip);
        if($data)
        {
            return view('landing.index',compact('data'));
        }
        else
        {
            return view('error-page.404');
        }
    }
}
