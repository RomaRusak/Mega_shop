<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Repositories\ProductVariantRepository;

class ProductsService {

    private $productVariantRepository = null;

    public function __construct(
        ProductVariantRepository $productVariantRepository,
    )
    {
        $this->productVariantRepository = $productVariantRepository;
    }

    public function transformProducts(Collection $products): Collection
    {
        $transformedProducts = $products->map(function ($product) {
            $product->product_variants = $product->productVariants->map(function($variant) {
                $productPrice = (float) $variant->price;
                $finalPrice   = $productPrice;
                $discounts = $variant->discounts->toArray();

                if (count($discounts)) {
                    $actualDiscounts = $this->productVariantRepository->getActualDiscounts($discounts);
                    
                    if (count($actualDiscounts)) {
                        $actualDiscountValues = $this->productVariantRepository->getActualDiscountValues($actualDiscounts);
                        $maxActualDiscount = max($actualDiscountValues);
                        $finalPrice = round($this->productVariantRepository->getFinalPrice($productPrice, $maxActualDiscount), 2);
                    }
                }

                $variant->price_with_discount = $finalPrice;
                return $variant;
            });
            return $product;
        });
        
        return $transformedProducts;
    }

    public function filterByPrice(Collection $products, array $filterParams)
    {
        $minPrice = isset($filterParams['min_price']) ? $filterParams['min_price'] : -INF;
        $maxPrice = isset($filterParams['max_price']) ? $filterParams['max_price'] : INF;

        $filteredProducts = $products->filter(function ($product) use ($minPrice, $maxPrice) {
            $prodVarPricesArr = array_map(function($variant) {
                return $variant['price_with_discount'];
            }, $product->product_variants->toArray()); 

            $maxProdVarPrice = max($prodVarPricesArr);
            $minProdVarPrice = min($prodVarPricesArr);

            return $maxProdVarPrice <= $maxPrice && $minProdVarPrice >= $minPrice;
        });

        return $filteredProducts;
    }
}