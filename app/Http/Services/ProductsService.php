<?php

namespace App\Http\Services;
use App\Models\Product;

class ProductsService {
    private $productModel        = null;

    public function __construct(
        Product $productModel,
        )
    {
        $this->productModel        = $productModel;
    }

    public function getFiltProductsResponcse(array $preparedRequestParams): array
    {
        $page              = $preparedRequestParams['page'];
        $productsPerPage   = $preparedRequestParams['products_per_page'];

        $responseData = [
            'page'                  => $page,
            'products_per_page'     => $productsPerPage,
            'total_showed_products' => null,
            'total_products'        => null,
            'total_pages'           => null,
            'products'              => [],
        ];

        $getFiltProductsQuery = $this->productModel->getFilProductsQuery($preparedRequestParams);
        $totalFiltProduct     = $getFiltProductsQuery->count();
        
        $getFiltProductsQuery->forPage($page, $productsPerPage);
        
        $filtProducts            = $getFiltProductsQuery->get()->toArray();
        $totalShowedFiltProducts = count($filtProducts);

        $responseData['total_products']        = $totalFiltProduct;
        $responseData['total_showed_products'] = $totalShowedFiltProducts;
        
        $totalPages = $productsPerPage > 0 
                                    ? ((int) ceil($totalFiltProduct / $productsPerPage)) 
                                    : 0;

        $responseData['total_pages']  = $totalPages;
        $responseData['products']     = $filtProducts;

        return $responseData;
    }
}