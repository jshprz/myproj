<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\buildcommerce\Repository\StoreRepositoryInterface;

class HomeController extends Controller
{
    public function __contruct(StoreRepositoryInterface $store)
    {
        $this->store = $store;
    }
}
