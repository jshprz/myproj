<?php
namespace App\buildcommerce\Repository\client\Eloquent;

use App\buildcommerce\Repository\client\TransactionRepositoryInterface;
use App\buildcommerce\Repository\client\StoreRepositoryInterface;
use App\buildcommerce\Models\Transactions;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;

class TransactionRepository extends AbstractRepository implements TransactionRepositoryInterface
{
    public function __construct(Transactions $transaction, StoreRepositoryInterface $store)
    {
        $this->model = $transaction;
        $this->store = $store;
    }

    public function transactionAnalytics($request)
    {
        $store_data = $this->store->getStoreByName($request->storeName);
        $new_transaction = $this->model->join('products','transactions.product_id','=','products.id')->select('transactions.*','products.store_id')->where('transactions.created_at', '>=', Carbon::now()->startOfMonth())->where('products.store_id',$store_data->id)->count();
        $pending_transaction = $this->model->join('products','transactions.product_id','=','products.id')->select('transactions.*','products.store_id')->where('transactions.status','pending')->where('products.store_id',$store_data->id)->count();
        $cancelled_transaction = $this->model->join('products','transactions.product_id','=','products.id')->select('transactions.*','products.store_id')->where('transactions.status','cancelled')->where('products.store_id',$store_data->id)->count();
        $completed_transaction = $this->model->join('products','transactions.product_id','=','products.id')->select('transactions.*','products.store_id')->where('transactions.status','delivered')->where('products.store_id',$store_data->id)->count();

        return response()->json([
            'pending' => $pending_transaction,
            'cancelled' => $cancelled_transaction,
            'completed' => $completed_transaction,
            'new' => $new_transaction
        ]);
    }

    public function getTransactions($request)
    {
        if(!is_null($request->searchInput))
        {
            if(is_null($request->status))
            {
                $store_data = $this->store->getStoreByName($request->storeName);
                $query = DB::table('transactions')->join('products','transactions.product_id','=','products.id')->select('transactions.*', 'products.*')->where('products.store_id',$store_data->id)->where('transactions.id','like',$request->searchInput)->get();
                return response()->json($query);
            }
            else
            {
                $store_data = $this->store->getStoreByName($request->storeName);
                $query = DB::table('transactions')->join('products','transactions.product_id','=','products.id')->select('transactions.*', 'products.*')->where('products.store_id',$store_data->id)->where('transactions.status',$request->status)->where('transactions.id','like',$request->searchInput)->get();
                return response()->json($query);
            }
        }
        else if(!is_null($request->status))
        {
            $store_data = $this->store->getStoreByName($request->storeName);
            $query = DB::table('transactions')->join('products','transactions.product_id','=','products.id')->select('transactions.*', 'products.*')->where('products.store_id',$store_data->id)->where('transactions.status','like',$request->status)->get();
            return response()->json($query);
        }
        else
        {
            $store_data = $this->store->getStoreByName($request->storeName);
            $query = DB::table('transactions')->join('products','transactions.product_id','=','products.id')->select('transactions.*', 'products.*')->where('products.store_id',$store_data->id)->get();
            return response()->json($query);     
        }
    }

    public function getTransactionsById($request)
    {
        $query = DB::table('transactions')->join('products','transactions.product_id','=','products.id')->select('transactions.*', 'products.*')->where('transactions.id',$request->id)->get();
        return response()->json($query); 
    }

}