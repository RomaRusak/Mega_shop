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
use App\Http\Services\ProductsService;

class ProductsController extends Controller
{   
    private $productModel              = null;
    private $generalHelper             = null;
    private $productsValidationService = null;
    private $productsService           = null;

    public function __construct(
        Product                   $product,
        GeneralHelper             $generalHelper,
        ProductsValidationService $productsValidationService,
        ProductsService           $productsService,
        )
    {
        $this->productModel              = $product;
        $this->generalHelper             = $generalHelper;
        $this->productsValidationService = $productsValidationService;
        $this->productsService           = $productsService;
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

        $filtetedProducts = $this->productModel->getFilteredProducts([
            'color'        => $request->color,
            'size'         => $request->size,
            'categorySlug' => $categorySlug,
            'brand'        => $request->brand,
        ]);

        $transformedFiltProducts = $this->productsService->transformProducts($filtetedProducts);
        $transformedFiltProducts = $this->productsService->filterByPrice(
            $transformedFiltProducts, ['min_price' => $request->min_price, 'max_price' => $request->max_price]
        );
        return new ProductsListResource([
            'page'                  => $request->page,
            'products_per_page'     => $request->products_per_page,
            'products'              => $transformedFiltProducts,
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
