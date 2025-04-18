<?php

namespace App\Http\Services;
use App\Models\ProductVariant;

class ProductsService {
    private $productVariantModel = null;

    public function __construct(
        ProductVariant  $productVariant,
        )
    {
        $this->productVariantModel = $productVariant;
    }

    public function getFiltProductVariantsResponcse(array $preparedRequestParams)
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

        $getfiltProdVariantsQuery   = $this->productVariantModel->getFilProductVariantsQuery($preparedRequestParams);
        $totalFiltProductVariants   = $getfiltProdVariantsQuery->count();
        
        $getfiltProdVariantsQuery->forPage($page, $productsPerPage);
        
        $filtProductVariants         = $getfiltProdVariantsQuery->get()->toArray();
        $totalShowedFiltProdVariants = count($filtProductVariants);

        $responseData['total_products']        = $totalFiltProductVariants;
        $responseData['total_showed_products'] = $totalShowedFiltProdVariants;
        
        $totalPages = $productsPerPage > 0 
                                    ? ((int) ceil($totalFiltProductVariants / $productsPerPage)) 
                                    : 0;

        $responseData['total_pages']  = $totalPages;
        $responseData['products']     = $filtProductVariants;

        return $responseData;
    }
}