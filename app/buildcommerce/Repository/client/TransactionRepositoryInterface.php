<?php
namespace App\buildcommerce\Repository\client;

interface TransactionRepositoryInterface
{
    public function transactionAnalytics($request);

    public function getTransactions($request);

    public function getTransactionsById($request);
   
}