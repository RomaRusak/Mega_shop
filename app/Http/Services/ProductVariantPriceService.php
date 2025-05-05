<?php

namespace App\Http\Services;

class ProductVariantPriceService {
    public function geAllProdVarPricesWithDisc(array $productsWithDiscount): array
    {
        $prices = [];

        foreach($productsWithDiscount as $productWithDiscount) {
            if (!count($productWithDiscount['discounts'])) {
                $prices[] = (float) $productWithDiscount['price'];
                continue;
            }

            $actualDiscounts = $this->getActualDiscounts($productWithDiscount['discounts']);
            $actualDiscountValues = $this->getActualDiscountValues($actualDiscounts);
            
            if (!count($actualDiscountValues)) {
                $prices[] = (float) $productWithDiscount['price'];
                continue;
            }

            $maxActualDiscount = max($actualDiscountValues);
            $productPrice = (float) $productWithDiscount['price'];

            $finalPrice = $this->getFinalPrice($productPrice, $maxActualDiscount);

            $prices[] = round($finalPrice, 2);
        }

        return $prices;
    }

    public function getActualDiscounts(array $discounts): array
    {
        return array_filter($discounts, function($discount) {
            return $discount['discount_start'] <= now() && $discount['discount_end'] >= now();
        });
    }

    public function getActualDiscountValues(array $actualDiscounts): array
    {
        return array_map(function($discount) {
            return (float) $discount['discount_percent'];
        }, $actualDiscounts);
    } 

    public function getFinalPrice(float $productPrice, float $maxActualDiscount) {
        return $productPrice - ($productPrice * $maxActualDiscount / 100);
    }
}