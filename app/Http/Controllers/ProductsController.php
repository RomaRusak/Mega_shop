<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexProductsRequest;
use App\Http\Services\ProductsService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Product;
use App\Http\Helpers\GeneralHelper;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ShowProductsRequest;

class ProductsController extends Controller
{   
    private $productsService     = null;
    private $productModel        = null;
    private $generalHelper       = null;

    public function __construct(
        ProductsService $productsService,
        Product         $product,
        GeneralHelper   $generalHelper,
        )
    {
        $this->productsService = $productsService;
        $this->productModel    = $product;
        $this->generalHelper   = $generalHelper;
    }

    public function index(IndexProductsRequest $request): JsonResponse
    {
        $filtProducts= $this->productsService->getFiltProductsResponcse($request->all());

        return response()->json($filtProducts);
    }

    public function show(ShowProductsRequest $request): JsonResponse
    {

        $productId = $this->generalHelper::getIdFromSlug($request->productSlug);

        $currentProductData = $this->productModel->getProductById($productId);

        return response()->json($currentProductData);
    }
}
