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
            'uniq_brands'       => $brandModel->select('name', 'slug')->get()->toArray(),
            'uniq_categories'   => $categoryModel->select('name', 'slug')->get()->toArray(),
            'uniq_colors'       => $productVariantModel->distinct('color')->pluck('color'),
            'uniq_sizes'        => $productVariantModel->distinct('size')->pluck('size'),
            'min_product_price' => $productVariantModel->min('price'),
            'max_product_price' => $productVariantModel->max('price')
        ]);
    }
}
