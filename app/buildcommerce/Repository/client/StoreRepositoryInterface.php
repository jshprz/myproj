<?php
namespace App\buildcommerce\Repository\client;

interface StoreRepositoryInterface
{
    public function createStore($request);

    public function getStoreByName($storeName);

    public function getStore();

    public function getStoreNotREST();

    public function getStoreById($id);

    public function savePayment($request);

    public function getPayment($request);

    public function getAuthenticatedStore();

    public function genQrCode($request);

    public function getStoreUsers($storeName);

    public function getStoreAnalytics($request);

    public function updateNew($id);

    public function changeSSHHost($request);
}