<?php
namespace App\buildcommerce\Repository\client\Eloquent;


use App\buildcommerce\Repository\client\Eloquent\AbstractRepository;
use App\buildcommerce\Repository\client\StoreRepositoryInterface;
use App\buildcommerce\Models\Store;
use App\buildcommerce\Models\Products;
use App\buildcommerce\Models\StoreUsers;
use App\buildcommerce\Models\Transactions;
use App\buildcommerce\Mailers\UserMailer;
use Illuminate\Http\Request;
use Auth;
use JD\Cloudder\Facades\Cloudder;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Mail;
use App\buildcommerce\Tasks\AwsTask;
use AWS;
use SSH;

class StoreRepository extends AbstractRepository implements StoreRepositoryInterface
{
    public function __construct(Store $store, UserMailer $mailer,StoreUsers $users,Products $product,Transactions $transaction, AwsTask $awsTask)
    {
        $this->model = $store;
        $this->user = $users; 
        $this->mailer = $mailer;
        $this->product = $product;
        $this->transaction = $transaction;
        $this->awsTask = $awsTask;
    }

    public function getStoreByName($storeName)
    {
        $query = $this->model->where('store_name',$storeName)->first();
        if($query)
        {
            return $this->model->where('store_name',$storeName)->first();
        }
        else
        {
            return false;
        }
    }

    public function getStoreById($id)
    {
        $query = $this->model->where('id',$id)->first();
        if($query)
        {
            return $this->model->where('id',$id)->first();
        }
        else
        {
            return false;
        }
    }

    public function getStoreNotREST()
    {
        return $this->model->where('user_id',auth()->user()->id)->where('approved',true)->get();
    }

    public function getStore()
    {
        $query = $this->model->where('user_id',auth()->user()->id)->where('approved',true)->get();
        return response()->json($query);
    }

    public function createStore($request)
    {
        $code = sha1(str_random(11) . (time() * rand(2, 2000)));
        $file = $request->file('pic');
        $hashed_file = array();
        foreach($file as $key)
        {
            $extension = $key->getClientOriginalExtension();
            $key->store('public/verify');
            Cloudder::upload($key->getRealPath(), basename($key->hashName(),'.'.$extension));
            array_push($hashed_file,$key->hashName());
        }
        $get_store = $this->model->where('user_id',Auth::user()->id)->get();
        if(count($get_store) >= 3)
        {
            return false;
        }
        else{
            $imploded = implode(',',$hashed_file);
        $this->model->user_id = auth()->user()->id;
        $this->model->image_verification = $imploded;
        $this->model->url = $request->url_field;
        $this->model->store_name = $request->store_name;
        $this->model->store_type = $request->store_type;
        $this->model->store_email = $request->email;
        $this->model->store_contact_number = $request->store_contact_number;
        $this->model->store_description = $request->store_description;
        $this->model->store_code = $code;
        $this->model->save();
 

        return true;
        
    }
    }

    public function savePayment($request)
    {
        $payment_array = array();
        if($request->stripe == true)
        {
            $payment_array[] = 'stripe';
        }
        else
        {
            $payment_array[] = '';
        }
        if($request->paypal == true)
        {
            $payment_array[] = 'paypal';
        }
        else
        {
            $payment_array[] = '';
        }
        $imploded_payment = implode(',', $payment_array);
        $store_data = $this->getStoreByName($request->storeName);
        $query = $this->model->where('id',$store_data->id)->update(['payment' => $imploded_payment]);
        if($query)
        {
            return response()->json(true);
        }
        else
        {
            return response()->json(false);
        }
    }
    
    public function getPayment($request)
    {
        $store_data = $this->getStoreByName($request->storeName);
        $query = $this->model->select('payment')->where('id',$store_data->id)->first();
        return response()->json($query);
    }

    public function getAuthenticatedStore()
    {
        $store_data = $this->getStoreById(Auth::guard('buyer')->user()->store_id);
        return response()->json($store_data);
    }

    public function genQrCode($request)
    {
        $qr_generate = QrCode::generate($request->qrcode);
        return response()->json($qr_generate);
    }

    public function getStoreUsers($storeName)
    {
        $store_id = $this->getStoreByName($storeName)->id;

        return $this->user->where('store_id',$store_id)->get();
    }

    public function getStoreAnalytics($request)
    {
        $store_data = $this->getStoreByName($request->storeName);
        $product_count = $this->product->where('store_id',$store_data->id)->count();
        $transaction_count = $this->transaction->join('products','transactions.product_id','=','products.id')->where('products.store_id',$store_data->id)->count();
        $customer_count = $this->user->where('store_id',$store_data->id)->count();
        $total_sales = $this->transaction->join('products','transactions.product_id','=','products.id')->where('products.store_id',$store_data->id)->sum('transactions.total_paid');
       return response()->json([
            'product_count' => $product_count,
            'transaction_count' => $transaction_count,
            'customer_count' => $customer_count,
            'total_sales' => $total_sales
       ]);
        
    }

    public function updateNew($id)
    {
        $this->awsTask->setupInstance();
        $this->model->where('id',$id)->update(['new' => false]);
    }

    public function changeSSHHost($request)
    {
        $ec2 = AWS::createClient('ec2');
        $result = $ec2->describeInstances(array(
            'InstanceIds' => [$request->instance_id],
        ));
        changeEnv([
            'SSH_HOST' => $result['Reservations'][0]['Instances'][0]['PublicIpAddress']
        ]);
        $this->model->where('id',$request->store_id)->update(['instance_public_ip_address' => $result['Reservations'][0]['Instances'][0]['PublicIpAddress']]);
        return response()->json($request->instance_id);
    }
    
}