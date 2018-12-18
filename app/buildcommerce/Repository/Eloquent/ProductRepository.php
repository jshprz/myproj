<?php
namespace App\buildcommerce\Repository\Eloquent;

use App\buildcommerce\Repository\Eloquent\AbstractRepository;
use App\buildcommerce\Models\ProductCategory;
use App\buildcommerce\Models\Products;
use App\buildcommerce\Models\Feedback;
use App\buildcommerce\Repository\ProductRepositoryInterface;
use App\buildcommerce\Repository\StoreRepositoryInterface;
use Cart;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface{

    public function __construct(ProductCategory $product_category, Products $product, StoreRepositoryInterface $store, Cart $cart, Feedback $feedback)
    {
        $this->model = $product;
        $this->product_category = $product_category;
        $this->store = $store;
        $this->cart = $cart;
        $this->feedback = $feedback;

    }

    public function getProductCategoryById($id)
    {
        return $this->product_category->where('id',$id)->first();
    }

    public function getSimilarProduct($request)
    {
        $private_ip = $request->server('SERVER_ADDR');
        $store_id = $this->store->getStoreByPrivateIp($private_ip)->id;
        return $this->model->where('store_id',$store_id)->where('product_category_id',$request->product_category_id)->whereNotIn('id',[$request->product_id])->get();
    }
    
    public function getProductById($id)
    {
        $private_ip = $request->server('SERVER_ADDR');
        $store_id = $this->store->getStoreByPrivateIp($private_ip)->id;
        $query = $this->model->where('store_id', $store_id)->where('id',$id)->first();
        if($query)
        {
            return $query;
        }
        else
        {
            return false;
        }
    }

     public function searchByPriceRange($request)
     {
         $private_ip = $request->server('SERVER_ADDR');
         $store_id = $this->store->getStoreByPrivateIp($private_ip)->id;
         $data = $this->model->whereBetween('product_original_price',[$request->minimum,$request->maximum])->where('store_id',$store_id)->get();
         return response()->json($data);  
     }

     public function getProductFeedback($product_id)
     {
         return $this->feedback->join('store_users','feedback.buyer_id','=','store_users.id')->select('feedback.*','store_users.firstname','store_users.lastname')->where('feedback.product_id',$product_id)->get();
     }

     public function searchBySlider($request)
     {
         $private_ip = $request->server('SERVER_ADDR');
         $store_id = $this->store->getStoreByPrivateIp($private_ip)->id;
         $data = $this->model->whereBetween('product_original_price',[0,$request->price])->where('store_id',$store_id)->get();
         return response()->json($data);
     }

     public function getProductsToBeDisplayed($request)
     {
        if(empty($request->searchProduct))
        {
            $private_ip = $request->server('SERVER_ADDR');
            $store_id = $this->store->getStoreByPrivateIp($private_ip)->id;
        $product_category_id = $this->product_category->getProductCategoryByName($request->productCategory)->id;
        $data =  $this->model->where('product_category_id',$product_category_id)->with('productCategory')->with('store')->where('store_id',$store_id)->paginate(9);
        return response()->json($data);
        }
        else
        {
            $private_ip = $request->server('SERVER_ADDR');
            $store_id = $this->store->getStoreByPrivateIp($private_ip)->id;
        $product_category_id = $this->product_category->getProductCategoryByName($request->productCategory)->id;
        $data =  $this->model->where('product_category_id',$product_category_id)->where('product_name','like',$request->searchProduct.'%')->with('productCategory')->with('store')->where('store_id',$store_id)->paginate(9);
        return response()->json($data);
        }
    }

    public function getProductCategoryTobeDisplayed($request)
    {
        $private_ip = $request->server('SERVER_ADDR');
        $store_id = $this->store->getStoreByPrivateIp($private_ip)->id;
        $data = $this->product_category->with('store')->where('store_id',$store_id)->with('product')->get();
        return response()->json($data);
    }

    public function addToCart($request)
    {
        $product_quantity = $this->model->where('id',$request->item_id)->first()->product_quantity;   
        if($request->item_quantity > $product_quantity)
        {
            return redirect()->back()->with('flashError','You reached the quantity');   
        }
        else
        {
            $cart = Cart::add($request->item_id, $request->item_name, $request->item_quantity, $request->item_price, ['image' => $request->item_image,'shipping_fee' => doubleval($request->item_shipping_fee),'tax' => doubleval($request->item_tax)]);

            return redirect()->back();
        }
    }
}