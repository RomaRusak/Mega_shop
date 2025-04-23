<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource        = $this->resource;
        $page            = $resource['page'];
        $productsPerPage = $resource['products_per_page'];
        
        $products                = $resource['products'];
        $totalProducts           = $products->count();
        $paginatedProducts       = $products->forPage($page, $productsPerPage);
        $totalShowedProducts     = count($paginatedProducts);
        
        $response['total_products']        = $totalProducts;
        $response['total_showed_products'] = $totalShowedProducts;

        $totalPages = $productsPerPage > 0 
                                    ? ((int) ceil($totalProducts / $productsPerPage)) 
                                    : 0;
        return [
            'pagination'            => [
                'page'                  => $page,
                'products_per_page'     => $productsPerPage,
                'total_showed_products' => $totalShowedProducts,
                'total_products'        => $totalProducts,
                'total_pages'           => $totalPages,
            ],
            'products'              => $paginatedProducts->toArray(),
        ];
    }
}
