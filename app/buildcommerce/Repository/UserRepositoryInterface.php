<?php
namespace App\buildcommerce\Repository;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function registerBuyerAccount($request);

    public function activate($token);

    public function verifyIfAuthenticated($storeName);

    public function createFeedback($request);

    public function createStar($request);
}