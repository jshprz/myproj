<?php
namespace App\buildcommerce\Repository;

interface TransactionRepositoryInterface
{
    public function lastTransaction();

    public function getTransactions();

    public function getTransactionsById($request);

   
}