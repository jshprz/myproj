<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\buildcommerce\Repository\StoreRepositoryInterface;
use App\buildcommerce\Repository\PaymentRepositoryInterface;
use Session;

class PaymentController extends Controller
{
   	public function __construct(StoreRepositoryInterface $store, PaymentRepositoryInterface $payment)
    {
        $this->store = $store; 
        $this->payment = $payment;
    }
    public function index(Request $request,$storeName)
    {
        $data = $this->store->getStoreByName($storeName);
        $total_checkout = $request->total_checkout;
        $ship_fee = $request->ship_fee;
        $tax = $request->tax;
        $subtotal = $request->subtotal;
       
        Session::put('cart_id',$request->cart);

        if($data)
        {
            return view('payment.payment',compact('storeName','total_checkout','ship_fee','tax','subtotal','data'));
        }
        else
        {
            return view('error-page.404');
        }
    }

    public function payWithPaypal(Request $request,$storeName)
    {
        return $this->payment->payWithPaypal($request,$storeName);
    }
    public function getPaypalPaymentStatus($storeName)
    {
        return $this->payment->getPaypalPaymentStatus($storeName);
    }

    public function payWithStripe(Request $request,$storeName)
    {
        return $this->payment->payWithStripe($request, $storeName);
    }

    public function createDelivery(Request $request,$storeName)
    {
        
        return $this->payment->createDelivery($request,$storeName);
    }

    public function trackDelivery($storeName)
    {
        return $this->payment->trackDelivery($storeName);
    }

    public function selectCourier(Request $request, $storeName)
    {
        Session::put('fullname',$request->fullname);
        Session::put('email',$request->email);
        Session::put('house_detail',$request->house_detail);
        Session::put('street',$request->street);
        Session::put('city',$request->city);
        Session::put('zip',$request->zip);
        Session::put('barangay',$request->barangay);
        Session::put('phone_number',$request->phone_number);
        Session::put('total_checkout',$request->total_checkout);
        
        Session::put('order_id',$request->order_id);
        
        return view('select-courier.index',compact('storeName'));
    }
}
