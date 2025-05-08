<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsIndexRequest;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Product;
use App\Http\Helpers\GeneralHelper;
use App\Http\Resources\ProductsListResource;
use App\Http\Resources\ProductResource;
use Illuminate\Http\JsonResponse;
use App\Http\Services\ProductsValidationService;

class ProductsController extends Controller
{   
    private $productModel              = null;
    private $generalHelper             = null;
    private $productsValidationService = null;

    public function __construct(
        Product                   $product,
        GeneralHelper             $generalHelper,
        ProductsValidationService $productsValidationService
        )
    {
        $this->productModel              = $product;
        $this->generalHelper             = $generalHelper;
        $this->productsValidationService = $productsValidationService;
    }

    public function index(ProductsIndexRequest $request): ProductsListResource|JsonResponse
    {
        $categorySlug = $request->categorySlug;

        if (isset($categorySlug)) {
            $validator = $this->productsValidationService->validate(['categorySlug' => $categorySlug]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }
        }

        $filtetedProducts = $this->productModel->getFilteredProducts([...$request->all(), 'categorySlug' => $categorySlug]);

        return new ProductsListResource([
            'page'                  => $request->page,
            'products_per_page'     => $request->products_per_page,
            'products'              => $filtetedProducts,
        ]);
    }

    public function show(Request $request): ProductResource|JsonResponse
    {
        $categorySlug = $request->categorySlug;
        $productSlug = $request->productSlug;
        
        $validationParams = ['productSlug' => $productSlug];

        if (isset($categorySlug)) {
            $validationParams['categorySlug'] = $categorySlug;
        }
        
        $validator = $this->productsValidationService->validate($validationParams);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $productId = $this->generalHelper::getIdFromSlug($productSlug);

        return new ProductResource($this->productModel->getProductById($productId));
    }
    
}
