<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\buildcommerce\Repository\StoreRepositoryInterface;
use App\buildcommerce\Repository\ProductRepositoryInterface;
use App\buildcommerce\Repository\UserRepositoryInterface;
use Auth;
use Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShopController extends Controller
{
    public function __construct(StoreRepositoryInterface $store, ProductRepositoryInterface $product, UserRepositoryInterface $user)
    {
        $this->store = $store;
        $this->product = $product;
        $this->user = $user;
        
    }
    public function index(Request $request)
    {
        $private_ip = $request->server('SERVER_ADDR');
        $data = $this->store->getStoreByPrivateIp($private_ip);
        if($data)
        {
            $buyer_auth_verify = $this->user->verifyIfAuthenticated($request);
            if($buyer_auth_verify)
            {
                return view('shop.index',compact('data'));
            }
            else
            {
                return view('error-page.404');
            }
        }
        else
        {
            return view('error-page.404');
        }
    }
    public function getProductsToBeDisplayed(Request $request)
    {
        return $this->product->getProductsToBeDisplayed($request);
    }
    public function getProductCategoryTobeDisplayed(Request $request)
    {
        return $this->product->getProductCategoryTobeDisplayed($request);
    }
    public function addToCart(Request $request)
    {
        return $this->product->addToCart($request);
    }

    public function viewCart()
    {
        $private_ip = $request->server('SERVER_ADDR');
        $data = $this->store->getStoreByPrivateIp($private_ip);
        if($data)
        {
            return view('checkout.checkout');
        }
        else
        {
            return view('error-page.404');
        }
    }

    public function savePayment(Request $request)
    {
        return $this->store->savePayment($request);
    }
    
    public function getPayment(Request $request)
    {
        return $this->store->getPayment($request);
    }

    public function cartDataPost(Request $request)
    {
        Cart::update($request->row_id,['qty' => $request->quantity]);
        return response()->json([
                'content' => Cart::content(),
                'subtotal' => Cart::subtotal(),
                'count' => Cart::content()->count()
        ]);
    }

    public function cartDataGet()
    {
        return response()->json([
                'content' => Cart::content(),
                'subtotal' => Cart::subtotal(),
                'count' => Cart::content()->count()
        ]);
    }

    public function removeItemFromCart(Request $request)
    {
        Cart::remove($request->row_id);
        return response()->json(true);
    }

    public function getAuthenticatedStore()
    {
        return $this->store->getAuthenticatedStore();
    }

    public function createFeedback(Request $request)
    {
        if($this->user->createFeedback($request))
        {
            return response()->json(['success' => true]);
        }
        else
        {
            return response()->json(['success' => false]);
        }
    }

    public function createStar(Request $request)
    {
        return $this->user->createStar($request);
    }
}
