<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexProductsRequest;
use App\Http\Services\ProductsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Product;
use App\Http\Helpers\GeneralHelper;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

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

    public function show(Request $request)
    {
        $id       = $request->id;
        $category = $request->category;

        $validatorData = ['id' => $id];
        $validatorRules = ['id' => 'required|numeric|exists:products,id'];

        if (isset($category)) {
            $transformedCategory = $this->generalHelper->underscoresToSpace($category);
            
            $validatorData['category'] = $transformedCategory;
            $validatorRules['category'] = [
                'string',
                Rule::exists('categories', 'name')->where(function (Builder $query) use ($transformedCategory, $id) {
                    $query->where(DB::raw('LOWER(name)'), $transformedCategory);
                }),
            ];
        }

        $validator = Validator::make($validatorData, $validatorRules);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $currentProductData = $this->productModel->getProductById($id);

        return response()->json($currentProductData);
    }
}
