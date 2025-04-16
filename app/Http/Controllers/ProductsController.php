<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductVariant;

class ProductsController extends Controller
{   
    private $productVariantModel = null;

    public function __construct(
        ProductVariant $productVariant
        )
    {
        $this->productVariantModel = $productVariant;
    }

    private function convertToReqType(mixed $value, array $allowedRequestParamTypes, string $queryReqType, mixed $defaultValue)
    {
        if (!in_array(gettype($value), $allowedRequestParamTypes)) {
            return $defaultValue;
        }

        switch($queryReqType) {
            case 'array':
                return (array) $value;
            case 'string':
                return (string) $value;
            case 'integer':
                return (integer) $value;
            case 'float':
                return (float) $value;
        }
    }

    private function prepareRequestParams(array $queryData, array $requestParams): array
    {
        foreach($requestParams as $key => &$value) {
            $queryReqType   = $queryData[$key]['queryReqType'];
            $isQueryReqType = gettype($value) === $queryReqType;
            
            if (!$isQueryReqType) {
                $allowedRequestParamTypes = $queryData[$key]['allowedRequestParamTypes'];
                $defaultValue             = $queryData[$key]['defaultValue'];

                $value = $this->convertToReqType($value, $allowedRequestParamTypes, $queryReqType, $defaultValue);
            }
        }

        return $requestParams;
    }

    public function index(Request $request)
    {
        $queryData = [
            'color'              => [
                'defaultValue'             => [],
                'allowedRequestParamTypes' => ['string', 'array'],
                'queryReqType'             => 'array',
            ],
            'size'               => [
                'defaultValue'             => [],
                'allowedRequestParamTypes' => ['string', 'array'],
                'queryReqType'             => 'array',
            ],
            'min_price'          => [
                'defaultValue'             => null,
                'allowedRequestParamTypes' => ['integer', 'string', 'float'],
                'queryReqType'             => 'float',
            ],
            'max_price'          => [
                'defaultValue'             => null,
                'allowedRequestParamTypes' => ['integer', 'string', 'float'],
                'queryReqType'             => 'float',
            ],
            'page'               => [
                'defaultValue'             => 1,
                'allowedRequestParamTypes' => ['integer', 'string'],
                'queryReqType'             => 'integer',
            ],
            'products_per_page'  => [
                'defaultValue'             => 20,
                'allowedRequestParamTypes' => ['integer', 'string'],
                'queryReqType'             => 'integer',
            ],
            'brand'              => [
                'defaultValue'             => [],
                'allowedRequestParamTypes' => ['string', 'array'],
                'queryReqType'             => 'array',
            ],
            'category'           => [
                'defaultValue'             => null,
                'allowedRequestParamTypes' => ['string'],
                'queryReqType'             => 'string',
            ],
        ];
        //Поправить! Проверяю только переданные параметры
        $requestParams = [];
        $requestParams['color']             = $request->input('color', $queryData['color']['defaultValue']);
        $requestParams['size']              = $request->input('size', $queryData['size']['defaultValue']);
        $requestParams['min_price']         = $request->input('min_price', $queryData['min_price']['defaultValue']);
        $requestParams['max_price']         = $request->input('max_price', $queryData['max_price']['defaultValue']);
        $requestParams['page']              = $request->input('page', $queryData['page']['defaultValue']);
        $requestParams['products_per_page'] = $request->input('products_per_page', $queryData['products_per_page']['defaultValue']);
        $requestParams['brand']             = $request->input('brand', $queryData['brand']['defaultValue']);
        $requestParams['category']          = $request->category;

        $preparedRequestParams = $this->prepareRequestParams($queryData, $requestParams);

        $responseData = $this->getResponseData($preparedRequestParams);
        return response()->json($responseData);
    }

    public function getResponseData(array $preparedRequestParams)
    {
        $brand             = $preparedRequestParams['brand'];
        $color             = $preparedRequestParams['color'];
        $size              = $preparedRequestParams['size'];
        $minPrice          = $preparedRequestParams['min_price'];
        $maxPrice          = $preparedRequestParams['max_price'];
        $page              = $preparedRequestParams['page'];
        $productsPerPage   = $preparedRequestParams['products_per_page'];
        $category          = $preparedRequestParams['category'];

        $responseData = [
            'page'                  => $page,
            'products_per_page'     => $productsPerPage,
            'total_showed_products' => null,
            'total_products'        => null,
            'total_pages'           => null,
            'products'              => [],
        ];

        $query = $this->productVariantModel::join('products', 'product_variants.product_id', '=', 'products.id')
                                            ->join('galleries', 'product_variants.gallery_id', '=', 'galleries.id')
                                            ->join('brands', 'products.brand_id', '=', 'brands.id')
                                            ->join('categories', 'products.category_id', '=', 'categories.id')
                                            ->select(
                                                'product_variants.id as product_variant_id',
                                                'products.id as product_id',   
                                                'products.brand_id',
                                                'galleries.image_paths',
                                                'product_variants.size',
                                                'product_variants.color',
                                                'product_variants.price',
                                                'brands.name as brand_name',
                                                'categories.name as category_name'
                                            );
        //регистр и пробелы поправить!
        if (!empty($category)) {
            $query->where('categories.name', $category);
        }
        
        if (!empty($brand)) {
            $query->whereIn('brands.name', $brand); 
        }

        if (!empty($color)) {
            $query->whereIn('color', $color);
        }

        if (!empty($size)) {
            $query->whereIn('size', $size);
        }

        if (!empty($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }

        if (!empty($maxPrice)) {
            $query->where('maxPrice', '<=', $maxPrice);
        }

        $totalProducts       = $query->count();
        $query->forPage($page, $productsPerPage);
        
        $products            = $query->get()->toArray();
        $totalShowedProducts = count($products);

        $responseData['total_products']        = $totalProducts;
        $responseData['total_showed_products'] = $totalShowedProducts;
        
        $totalPages = $productsPerPage > 0 
                                    ? ((int) ceil($totalProducts / $productsPerPage)) 
                                    : 0;
        $responseData['total_pages']  = $totalPages;

        $responseData['products'] = $products;
        
        return $responseData;
    }
}
