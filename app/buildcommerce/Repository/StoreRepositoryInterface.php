<?php
namespace App\buildcommerce\Repository;

interface StoreRepositoryInterface
{
    public function getStoreByName($storeName);

    public function getStoreById($id);

    public function savePayment($request);

    public function getPayment($request);

    public function getAuthenticatedStore();

    public function genQrCode($request);

    public function getStoreByPrivateIp($private_ip);
}