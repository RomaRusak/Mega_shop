<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductVariant;

class FiltersController extends Controller
{

    public function index(
        Brand          $brandModel, 
        Category       $categoryModel, 
        ProductVariant $productVariantModel
        )
    {
        //метод getUniqValuesArr расширяет базовую модель
        $uniqBrandNames           = ['uniq_brands'       => $brandModel->getUniqValuesArr('name')];
        $uniqCategoryNames        = ['uniq_categories'   => $categoryModel->getUniqValuesArr('name')];
        $uniqProductVariantColors = ['uniq_colors'       => $productVariantModel->getUniqValuesArr('color')];
        $uniqProductVariantSizes  = ['uniq_sizes'        => $productVariantModel->getUniqValuesArr('size')];
        $minProductVariantPrice   = ['min_product_price' => $productVariantModel->min('price')];
        $maxProductVariantPrice   = ['max_product_price' => $productVariantModel->max('price')];

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
