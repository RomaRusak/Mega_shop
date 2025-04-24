<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FiltersListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource  = $this->resource;

        return [
            'uniq_brands'       => $resource['uniq_brands'],
            'uniq_categories'   => $resource['uniq_categories'],
            'uniq_colors'       => $resource['uniq_colors'],
            'uniq_sizes'        => $resource['uniq_sizes'],
            'min_product_price' => $resource['min_product_price'],
            'max_product_price' => $resource['max_product_price'],
        ];
    }
}
