<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\buildcommerce\Repository\StoreRepositoryInterface;
use App\buildcommerce\Repository\ProductRepositoryInterface;

class ProductController extends Controller
{
    public function __construct(StoreRepositoryInterface $store, ProductRepositoryInterface $product)
    {
        $this->store = $store; 
        $this->product = $product;
    }

    public function details(Request $request,$storeName)
    {
        $data = $this->store->getStoreByName($storeName);
        
        if($data)
        {
            $products = $this->product->getProductById($request->product_id,$storeName);
            $product_feedback = $this->product->getProductFeedback($request->product_id,$storeName);
           if($products)
           {
                $product_category = $this->product->getProductCategoryById($products->product_category_id);
                $exploded_images = explode(',',$products->product_image);

                return view('product-detail.details',compact('storeName','products','product_feedback','product_category','exploded_images','data'));
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
    
    public function getSimilarProduct(Request $request)
    {
        return $this->product->getSimilarProduct($request);
    }

    public function searchByPriceRange(Request $request)
    {
        return $this->product->searchByPriceRange($request);
    }

    public function searchBySlider(Request $request)
    {
        return $this->product->searchBySlider($request);
    }
}
