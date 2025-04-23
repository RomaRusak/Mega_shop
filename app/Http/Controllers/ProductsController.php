<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexProductsRequest;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Product;
use App\Http\Helpers\GeneralHelper;
use App\Http\Requests\ShowProductsRequest;
use App\Http\Resources\ProductsListResource;
use App\Http\Resources\ProductResource;

class ProductsController extends Controller
{   
    private $productModel        = null;
    private $generalHelper       = null;

    public function __construct(
        Product         $product,
        GeneralHelper   $generalHelper,
        )
    {
        $this->productModel    = $product;
        $this->generalHelper   = $generalHelper;
    }

    public function index(IndexProductsRequest $request): ProductsListResource
    {
        $filtetedProducts = $this->productModel->getFilteredProducts($request->all());

        return new ProductsListResource([
            'page'                  => $request->page,
            'products_per_page'     => $request->products_per_page,
            'products'              => $filtetedProducts,
        ]);
    }

    public function show(ShowProductsRequest $request): ProductResource
    {

        $productId = $this->generalHelper::getIdFromSlug($request->productSlug);

        return new ProductResource($this->productModel->getProductById($productId));
    }
}
