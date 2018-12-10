<?php
namespace App\buildcommerce\Repository\Eloquent;


use App\buildcommerce\Repository\Eloquent\AbstractRepository;
use App\buildcommerce\Repository\StoreRepositoryInterface;
use App\buildcommerce\Models\Store;
use Illuminate\Http\Request;
use Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StoreRepository extends AbstractRepository implements StoreRepositoryInterface
{
    public function __construct(Store $store)
    {
        $this->model = $store;
        $this->user = $users;
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
}