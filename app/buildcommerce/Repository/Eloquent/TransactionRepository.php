<?php
namespace App\buildcommerce\Repository\Eloquent;

use App\buildcommerce\Repository\TransactionRepositoryInterface;
use App\buildcommerce\Models\Transactions;
use Auth;
use Illuminate\Support\Facades\DB;

class TransactionRepository extends AbstractRepository implements TransactionRepositoryInterface
{
     public function __construct(Transactions $transactions)
     {
        $this->model = $transactions;
     }
     public function lastTransaction()
     {
         $query = $this->model->orderBy('id','desc')->first();
         return response()->json($query);
     }

     public function getTransactions()
     {
         $query = DB::table('transactions')->join('products','transactions.product_id','=','products.id')->select('transactions.*', 'products.product_image', 'products.product_name', 'products.product_original_price')->where('transactions.buyer_id',Auth::guard('buyer')->user()->id)->get();
         return response()->json($query);
     }

     public function getTransactionsById($request)
     {
        $query = DB::table('transactions')->join('products','transactions.product_id','=','products.id')->select('transactions.*', 'products.id','products.product_image', 'products.product_name', 'products.product_original_price')->where('transactions.id',$request->id)->get();
        return response()->json($query);
     }

     

}