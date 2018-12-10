<?php
namespace App\buildcommerce\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
  
    public function register()
    {
        $this->app->bind(
            'App\buildcommerce\Repository\UserRepositoryInterface',
            'App\buildcommerce\Repository\Eloquent\UserRepository'
        );
        $this->app->bind(
            'App\buildcommerce\Repository\ProductRepositoryInterface',
            'App\buildcommerce\Repository\Eloquent\ProductRepository'
        );
        $this->app->bind(
            'App\buildcommerce\Repository\PaymentRepositoryInterface',
            'App\buildcommerce\Repository\Eloquent\PaymentRepository'
        );
        $this->app->bind(
            'App\buildcommerce\Repository\StoreRepositoryInterface',
            'App\buildcommerce\Repository\Eloquent\StoreRepository'
        );
        $this->app->bind(
            'App\buildcommerce\Repository\TransactionRepositoryInterface',
            'App\buildcommerce\Repository\Eloquent\TransactionRepository'
        );

    }

}
