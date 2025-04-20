<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Http\Requests\IndexProductsRequest;
use App\Http\Services\ProductsService;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Product;

class ProductsController extends Controller
{   
    private $productsService     = null;
    private $productVariantModel = null;
    private $brandModel          = null;
    private $categoryModel       = null;
    private $productModel        = null;

    public function __construct(
        ProductVariant  $productVariant,
        ProductsService $productsService,
        Brand           $brand,
        Category        $category,
        Product         $product,
        )
    {
        $this->productVariantModel = $productVariant;
        $this->productsService     = $productsService;
        $this->brandModel          = $brand;
        $this->categoryModel       = $category;
        $this->productModel        = $product;
    }

    public function index(IndexProductsRequest $request): JsonResponse
    {
        $filtProducts= $this->productsService->getFiltProductsResponcse($request->all());

        //метод getUniqValuesArr расширяет базовую модель
        $uniqBrandNames           = ['uniq_brands' => $this->brandModel->getUniqValuesArr('name')];
        $uniqCategoryNames        = ['uniq_categories' => $this->categoryModel->getUniqValuesArr('name')];
        $uniqProductVariantColors = ['uniq_colors' => $this->productVariantModel->getUniqValuesArr('color')];
        $uniqProductVariantSizes  = ['uniq_sizes' => $this->productVariantModel->getUniqValuesArr('size')];
        $minProductVariantPrice   = ['min_product_price' => $this->productVariantModel->min('price')];
        $maxProductVariantPrice   = ['max_product_price' => $this->productVariantModel->max('price')];

        return response()->json([
            ...$filtProducts,
            ...$uniqBrandNames,
            ...$uniqCategoryNames,
            ...$uniqProductVariantColors,
            ...$uniqProductVariantSizes,
            ...$minProductVariantPrice,
            ...$maxProductVariantPrice
        ]);
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make(
            ['id' => $id], 
            ['id' => 'required|string|exists:products,id']
        );

        if ($validator->fails()) {
            return redirect()->route('products.index') 
                             ->withErrors($validator);             
        }

        $currentProductData = $this->productModel->getProductById($id);

        return response()->json($currentProductData);
    }
}
