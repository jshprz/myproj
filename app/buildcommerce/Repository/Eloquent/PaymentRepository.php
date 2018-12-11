<?php
namespace App\buildcommerce\Repository\Eloquent;

use App\buildcommerce\Repository\PaymentRepositoryInterface;
use Illuminate\Support\Facades\Input;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use Redirect;
use Session;
use URL;
use Cart;	
use App\buildcommerce\Models\Transactions;
use App\buildcommerce\Models\Products;
use Auth;
use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;

use Naxon\AfterShip\Facades\Couriers;
use Naxon\AfterShip\Facades\LastCheckPoint;
use Naxon\AfterShip\Facades\Notifications;
use Naxon\AfterShip\Facades\Trackings;

class PaymentRepository extends AbstractRepository implements PaymentRepositoryInterface
{
	protected $_api_context;

	public function __construct(Transactions $transaction, Products $product)
    {
        $this->model = $transaction;
        $this->product = $product;
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function payWithPaypal($request,$storeName)
    {
        Session::put('order_id',$request->order_id);
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
 
        $item_1 = new Item();
 
        $item_1->setName('1 Reservation') /** item name **/
            ->setCurrency('PHP')
            ->setQuantity(1)
            ->setPrice(floatval($request->total_checkout)); /** unit price **/
 
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
 
        $amount = new Amount();
        $amount->setCurrency('PHP')
            ->setTotal(floatval($request->total_checkout));
 
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');
 
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('paywithpaypalstatus',['storeName' => $storeName])) /** Specify return URL **/
            ->setCancelUrl(URL::route('paywithpaypalstatus',['storeName' => $storeName]));
 
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
 
            $payment->create($this->_api_context);
 
        } catch (\PayPal\Exception\PPConnectionException $ex) {
 
            if (\Config::get('app.debug')) {
                return redirect()->back()->with('flashError', 'Connection timeout');
 
            } else {
 
                return redirect()->back()->with('flashError', 'Some error occur, sorry for inconvenient');
 
            }
 
        }
 
        foreach ($payment->getLinks() as $link) {
 
            if ($link->getRel() == 'approval_url') {
 
                $redirect_url = $link->getHref();
                break;
 
            }
 
        }
 
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
 
        if (isset($redirect_url)) {
 
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
 
        }
        return redirect()->back()->with('flashError', 'Unknown error occurred');
 
    }

    public function getPaypalPaymentStatus($storeName)
    {
        $payment_id = Session::get('paypal_payment_id');
 
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
 
            return redirect()->back()->with('flashError', 'Payment failed');
 
        }
 
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
 
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
 	
        if ($result->getState() == 'approved') {
 				$json_transactions = $result->transactions;
        		$transaction_data = array();
        		$transaction_data_to_insert = array();
        	
        		foreach (Session::get('cart_id') as $key => $value) 
        		{
        			
        			$exploded_cart = explode('-', $value);

        			$transaction_data[$key]['buyer_id'] = Auth::user()->id;
        			$transaction_data[$key]['total_paid'] = $json_transactions[0]->amount->total;
                    $transaction_data[$key]['product_id'] = $exploded_cart[0];
                    $transaction_data[$key]['order_id'] = Session::get('order_id');
        			$transaction_data[$key]['payment_courier'] = 'paypal';
                    $transaction_data[$key]['quantity'] = $exploded_cart[1];
                    $transaction_data[$key]['status'] = 'pending';

                    if($this->product->where('id',$exploded_cart[0])->first()->product_quantity != 0)
                    {
                        $this->product->where('id',$exploded_cart[0])->decrement('product_quantity',$exploded_cart[1]);
                    }
                }
         
        		for($i = 0; $i < count($transaction_data); $i++)
        		{
        			$this->model->create($transaction_data[$i]);
        		}
        		
        		Session::forget('order_id');
        		Cart::destroy();
            return redirect()->route('auth.shops',['storeName' => $storeName])->with('flashSuccess', 'Payment success');
 
        }
        return redirect()->route('auth.viewcart',['storeName' => $storeName])->with('flashError', 'Payment failed');
 
    }

    public function payWithStripe($request, $storeName)
    {
    	dd($request->all());
    }

    public function createDelivery($request,$storeName)
    {
        
      $tracking_info = [
            'slug'    => $request->courier,
            'emails'  => [Session::get('email')],
            'title'   => Session::get('fullname'),
            'customer_name' => Session::get('fullname'),
            'order_id' => Session::get('order_id'),
            
        ];
        Trackings::create(sha1(str_random(11) . (time() * rand(2, 2000))),$tracking_info);
      return redirect()->route('trackDelivery',['storeName' => $storeName])->with('flashSuccess','Your delivery is pending');

    }   

    public function trackDelivery($storeName)
    {
        foreach (Session::get('cart_id') as $key => $value) 
        		{
        			$exploded_cart = explode('-', $value);

        			$transaction_data[$key]['buyer_id'] = Auth::user()->id;
        			$transaction_data[$key]['total_paid'] = Session::get('total_checkout');
                    $transaction_data[$key]['product_id'] = $exploded_cart[0];
                    $transaction_data[$key]['order_id'] = Session::get('order_id');
                    $transaction_data[$key]['payment_courier'] = 'paypal';
                    $transaction_data[$key]['quantity'] = $exploded_cart[1];
                    $transaction_data[$key]['status'] = 'pending';
                }
         
        		for($i = 0; $i < count($transaction_data); $i++)
        		{
        			$this->model->create($transaction_data[$i]);
        		}
        		
        		Session::forget('order_id');
        		Cart::destroy();

       return  view('track.index',compact('storeName'));
    }
}