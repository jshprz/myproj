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
    public function index(Request $request)
    {
        $private_ip = $request->server('SERVER_ADDR');
        $data = $this->store->getStoreByPrivateIp($private_ip);
        $total_checkout = $request->total_checkout;
        $ship_fee = $request->ship_fee;
        $tax = $request->tax;
        $subtotal = $request->subtotal;
       
        Session::put('cart_id',$request->cart);

        if($data)
        {
            return view('payment.payment',compact('total_checkout','ship_fee','tax','subtotal','data'));
        }
        else
        {
            return view('error-page.404');
        }
    }

    public function payWithPaypal(Request $request)
    {
        return $this->payment->payWithPaypal($request);
    }
    public function getPaypalPaymentStatus()
    {
        return $this->payment->getPaypalPaymentStatus();
    }

    public function payWithStripe(Request $request)
    {
        return $this->payment->payWithStripe($request);
    }

    public function createDelivery(Request $request)
    {
        
        return $this->payment->createDelivery($request);
    }

    public function trackDelivery()
    {
        return $this->payment->trackDelivery();
    }

    public function selectCourier(Request $request)
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
        
        return view('select-courier.index');
    }
}
