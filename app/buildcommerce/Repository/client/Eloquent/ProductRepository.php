<?php
namespace App\buildcommerce\Repository\client\Eloquent;

use App\buildcommerce\Repository\client\Eloquent\AbstractRepository;
use App\buildcommerce\Repository\client\ProductRepositoryInterface;
use App\buildcommerce\Models\Products;
use App\buildcommerce\Models\Category;
use App\buildcommerce\Models\ProductCategory;
use App\buildcommerce\Repository\client\StoreRepositoryInterface;
use JD\Cloudder\Facades\Cloudder;
use App\buildcommerce\Models\Feedback;
use Gloudemans\Shoppingcart\Facades\Cart;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    public function __construct(Products $products, StoreRepositoryInterface $store, Category $category, ProductCategory $product_category, Feedback $feedback)
    {
        $this->model = $products; 
        $this->store = $store;
        $this->category = $category;
        $this->product_category = $product_category;
        $this->feedback = $feedback;
    }

    public function productCreate($request)
    {   
        $file = $request->file('product_pic');
        $hashed_file = array();
        foreach($file as $key)
        {
            $extension = $key->getClientOriginalExtension();
            $key->store('public/product');
            Cloudder::upload($key->getRealPath(), basename($key->hashName(),'.'.$extension));
            array_push($hashed_file,$key->hashName());
        }
        $data_store = $this->store->getStoreByName($request->store_name);
        $product_category_id = $this->product_category->getProductCategoryByName($request->product_category)->id;
        $imploded = implode(',',$hashed_file);
        $this->model->store_id = $data_store->id;
        $this->model->product_image = $imploded;
        $this->model->product_name = $request->product_name;
        $this->model->product_category_id = $product_category_id;
        $this->model->product_original_price = $request->product_original_price;
        $this->model->product_description = $request->product_description;
        $this->model->product_quantity = $request->product_quantity;
        $this->model->product_stock_alert = $request->product_stock_alert;
        $this->model->product_manufacturer = $request->product_manufacturer;
        $this->model->product_size = $request->product_size; 
        $this->model->track_product = $request->track_product;
        $this->model->tax = $request->tax;
        if($request->free_ship == false)
        {
            $this->model->shipping_fee = $request->shipping_fee;
        }
        else
        {
            $this->model->shipping_fee = 0;
        }
        $this->model->save();

        return true;
    }
    
    public function getProduct()
    {
        return $this->model->all();
    }

    public function getProductsToBeDisplayed($request)
    {
        if(empty($request->searchProduct))
        {
            $store_id = $this->store->getStoreByName($request->storeName)->id;
        $product_category_id = $this->product_category->getProductCategoryByName($request->productCategory)->id;
        $data =  $this->model->where('product_category_id',$product_category_id)->with('productCategory')->with('store')->where('store_id',$store_id)->paginate(9);
        return response()->json($data);
        }
        else
        {
            $store_id = $this->store->getStoreByName($request->storeName)->id;
        $product_category_id = $this->product_category->getProductCategoryByName($request->productCategory)->id;
        $data =  $this->model->where('product_category_id',$product_category_id)->where('product_name','like',$request->searchProduct.'%')->with('productCategory')->with('store')->where('store_id',$store_id)->paginate(9);
        return response()->json($data);
        }
    }

    public function getProductCategory($request)
    {
        $store_id = $this->store->getStoreByName($request->storeName)->id;
        $data = $this->product_category->with('category')->with('store')->where('store_id',$store_id)->get();
        return response()->json($data);
    }

    public function getCategory()
    {
        $category_data = $this->category->all();
        return response()->json($category_data);
    }

    public function createProductCategory($request)
    {
       $store_id = $this->store->getStoreByName($request->storeName)->id;
       $this->product_category->store_id = $store_id;
       $this->product_category->category_name = $request->categoryName;
       $this->product_category->save();
       return true;
    }

    public function getProductCategoryTobeDisplayed($request)
    {
        $store_id = $this->store->getStoreByName($request->storeName)->id;
        $data = $this->product_category->with('store')->where('store_id',$store_id)->with('product')->get();
        return response()->json($data);
    }

    public function getProductFeedback($request)
    {
        $store_id = $this->store->getStoreByName($request->storeName)->id;
        $query = $this->feedback->join('store_users','feedback.buyer_id','=','store_users.id')->join('rate','rate.buyer_id','=','store_users.id')->select('feedback.*','store_users.firstname','store_users.lastname','rate.stars')->where('store_users.store_id',$store_id)->get();
        return response()->json($query);
    }
    
    public function getProductByIdREST($request)
    {
        $query = $this->model->where('id',$request->id)->first();

        return response()->json($query);
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
