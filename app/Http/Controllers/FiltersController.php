<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductVariant;

class FiltersController extends Controller
{

    private $brandModel          = null;
    private $categoryModel       = null;
    private $productVariantModel = null;

    public function __construct(
        Brand          $brand,
        Category       $category,
        ProductVariant $productVariant,
    )
    {
        $this->brandModel          = $brand;
        $this->categoryModel       = $category;
        $this->productVariantModel = $productVariant;
    }

    public function index()
    {
        //метод getUniqValuesArr расширяет базовую модель
        $uniqBrandNames           = ['uniq_brands' => $this->brandModel->getUniqValuesArr('name')];
        $uniqCategoryNames        = ['uniq_categories' => $this->categoryModel->getUniqValuesArr('name')];
        $uniqProductVariantColors = ['uniq_colors' => $this->productVariantModel->getUniqValuesArr('color')];
        $uniqProductVariantSizes  = ['uniq_sizes' => $this->productVariantModel->getUniqValuesArr('size')];
        $minProductVariantPrice   = ['min_product_price' => $this->productVariantModel->min('price')];
        $maxProductVariantPrice   = ['max_product_price' => $this->productVariantModel->max('price')];

        return response()->json([
            ...$uniqBrandNames,
            ...$uniqCategoryNames,
            ...$uniqProductVariantColors,
            ...$uniqProductVariantSizes,
            ...$minProductVariantPrice,
            ...$maxProductVariantPrice
        ]);
    }
}
