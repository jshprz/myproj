<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\buildcommerce\Repository\TransactionRepositoryInterface;

class TransactionController extends Controller
{
    public function __construct(TransactionRepositoryInterface $transaction)
    {
        $this->transaction = $transaction;
    }

    public function index()
    {
        return view('view-transaction.index');
    }
    
    public function lastTransaction()
    {
        return $this->transaction->lastTransaction();
    }

    public function getTransactions()
    {
        return $this->transaction->getTransactions();
    }

    public function getTransactionsById(Request $request)
    {
        return $this->transaction->getTransactionsById($request);
    }
}
