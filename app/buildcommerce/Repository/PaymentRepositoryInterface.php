<?php
namespace App\buildcommerce\Repository;

interface PaymentRepositoryInterface
{
	public function payWithPaypal($request);

	public function getPaypalPaymentStatus();

	public function payWithStripe($request);

	public function createDelivery($request);

	public function trackDelivery();
}		