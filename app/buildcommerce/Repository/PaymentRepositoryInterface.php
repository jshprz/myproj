<?php
namespace App\buildcommerce\Repository;

interface PaymentRepositoryInterface
{
	public function payWithPaypal($request,$storeName);

	public function getPaypalPaymentStatus($storeName);

	public function payWithStripe($request, $storeName);

	public function createDelivery($request,$storeName);

	public function trackDelivery($storeName);
}		