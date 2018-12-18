<?php
namespace App\buildcommerce\Repository;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function registerBuyerAccount($request);

    public function activate($token);

    public function verifyIfAuthenticated();

    public function createFeedback($request);

    public function createStar($request);
}