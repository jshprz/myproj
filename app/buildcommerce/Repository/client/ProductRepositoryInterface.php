<?php
namespace App\buildcommerce\Repository\client;

interface ProductRepositoryInterface
{

    public function productCreate($request);

    public function getProduct();

    public function getProductsToBeDisplayed($request);

    public function getCategory();

    public function createProductCategory($request);

    public function getProductCategory($request);

    public function getProductCategoryTobeDisplayed($request);

    public function getProductFeedback($request);

    public function getProductByIdREST($request);

    public function addToCart($request);
}