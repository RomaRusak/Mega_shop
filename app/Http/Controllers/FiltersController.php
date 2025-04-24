<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Http\Resources\FiltersListResource;

class FiltersController extends Controller
{

    public function index(
        Brand          $brandModel, 
        Category       $categoryModel, 
        ProductVariant $productVariantModel
        ): FiltersListResource
    {
        return new FiltersListResource([
            'uniq_brands'       => $brandModel->getUniqValuesArr('name'),
            'uniq_categories'   => $categoryModel->getUniqValuesArr('name'),
            'uniq_colors'       => $productVariantModel->getUniqValuesArr('color'),
            'uniq_sizes'        => $productVariantModel->getUniqValuesArr('size'),
            'min_product_price' => $productVariantModel->min('price'),
            'max_product_price' => $productVariantModel->max('price')
        ]);
    }
}
