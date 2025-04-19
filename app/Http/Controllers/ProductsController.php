<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Http\Requests\IndexProductsRequest;
use App\Http\Services\ProductsService;
use App\Models\Brand;
use App\Models\Category;

class ProductsController extends Controller
{   
    private $productsService     = null;
    private $productVariantModel = null;
    private $brandModel          = null;
    private $categoryModel       = null;

    public function __construct(
        ProductVariant  $productVariant,
        ProductsService $productsService,
        Brand           $brand,
        Category        $category,
        )
    {
        $this->productVariantModel = $productVariant;
        $this->productsService     = $productsService;
        $this->brandModel          = $brand;
        $this->categoryModel       = $category;
    }

    public function index(IndexProductsRequest $request)
    {
        $filtProductVariantsResponse = $this->productsService->getFiltProductVariantsResponcse($request->all());

        //метод getUniqValuesArr расширяет базовую модель
        $uniqBrandNames           = ['uniq_brands' => $this->brandModel->getUniqValuesArr('name')];
        $uniqCategoryNames        = ['uniq_categories' => $this->categoryModel->getUniqValuesArr('name')];
        $uniqProductVariantColors = ['uniq_colors' => $this->productVariantModel->getUniqValuesArr('color')];
        $uniqProductVariantSizes  = ['uniq_sizes' => $this->productVariantModel->getUniqValuesArr('size')];
        $minProductVariantPrice   = ['min_product_price' => $this->productVariantModel->min('price')];
        $maxProductVariantPrice   = ['max_product_price' => $this->productVariantModel->max('price')];

        return response()->json([
            ...$filtProductVariantsResponse,
            ...$uniqBrandNames,
            ...$uniqCategoryNames,
            ...$uniqProductVariantColors,
            ...$uniqProductVariantSizes,
            ...$minProductVariantPrice,
            ...$maxProductVariantPrice
        ]);
    }


}
