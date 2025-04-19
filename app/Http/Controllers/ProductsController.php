<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Http\Requests\IndexProductsRequest;
use App\Http\Services\ProductsService;

class ProductsController extends Controller
{   
    private $productsService     = null;
    private $productVariantModel = null;

    public function __construct(
        ProductVariant  $productVariant,
        ProductsService $productsService,
        )
    {
        $this->productVariantModel = $productVariant;
        $this->productsService     = $productsService;
    }

    public function index(IndexProductsRequest $request)
    {
        $filtProductVariantsResponse = $this->productsService->getFiltProductVariantsResponcse($request->all());
        dd($filtProductVariantsResponse);

        return response()->json($filtProductVariantsResponse);
    }


}
