<?php
namespace App\buildcommerce\Repository;

interface ProductRepositoryInterface
{
    public function getProductCategoryById($id);

    public function getSimilarProduct($request);

    public function getProductById($id,$request);

    public function searchByPriceRange($request);

    public function getProductFeedback($product_id);

    public function searchBySlider($request);

    public function getProductsToBeDisplayed($request);

	public function getProductCategoryTobeDisplayed($request);

	public function addToCart($request);
}