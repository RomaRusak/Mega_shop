<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Http\Resources\FiltersListResource;
use App\Http\Repositories\ProductVariantRepository;

class FiltersController extends Controller
{

    public function index(
        Brand                      $brandModel, 
        Category                   $categoryModel, 
        ProductVariant             $productVariantModel,
        ProductVariantRepository   $productVariantRepiository,
        ): FiltersListResource
    {

        $prodVarWithDiscounts      = $productVariantRepiository->getProdVarWithDiscounts();
        $allProdVarPricesWithDisc  = $productVariantRepiository->geAllProdVarPricesWithDisc($prodVarWithDiscounts);
        $minProductPrice           = floor(min($allProdVarPricesWithDisc));
        $maxProductPrice           = ceil(max($allProdVarPricesWithDisc));

        return new FiltersListResource([
            'uniq_brands'       => $brandModel->select('name', 'slug')->get()->toArray(),
            'uniq_categories'   => $categoryModel->select('name', 'slug')->get()->toArray(),
            'uniq_colors'       => $productVariantModel->distinct('color')->pluck('color'),
            'uniq_sizes'        => $productVariantModel->distinct('size')->pluck('size'),
            'min_product_price' => $minProductPrice,
            'max_product_price' => $maxProductPrice,
        ]);
    }
    
}
