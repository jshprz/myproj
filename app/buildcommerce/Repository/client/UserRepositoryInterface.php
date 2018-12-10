<?php
namespace App\buildcommerce\Repository\client;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function registerAccount($request);

    public function activate($token);

    public function getNotifications();

    public function unreadNotification();

    public function readNotification();
}