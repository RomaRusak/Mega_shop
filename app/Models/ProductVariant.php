<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    = 'product_variants';
    protected $fillable = ['product_id', 'gallery_id', 'size', 'color', 'quantity', 'price'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    public function discounts(): BelongsToMany
    {
       return $this->belongsToMany(Discount::class, 'discount_product_variant', 'product_variant_id', 'discount_id');
    }

    public function getFilProductVariantsQuery(array $preparedRequestParams): Builder
    {
        $brand             = $preparedRequestParams['brand'];
        $color             = $preparedRequestParams['color'];
        $size              = $preparedRequestParams['size'];
        $minPrice          = $preparedRequestParams['min_price'];
        $maxPrice          = $preparedRequestParams['max_price'];
        $category          = $preparedRequestParams['category'];

        $query = $this::select('id', 'size', 'color', 'product_id', 'gallery_id')->with([
            'product' => function ($query) {
                $query->select('id', 'category_id', 'brand_id');
            },

            'gallery' => function ($query) {
                $query->select('id', 'image_paths');
            },

            'product.brand' => function ($query) {
                $query->select('id', 'name');
            },

            'product.category' => function ($query) {
                $query->select('id', 'name');
            },

            'discounts' => function($query) {
                $query->select('discounts.id', 'discounts.discount_percent', 'discounts.discount_start', 'discounts.discount_end')
                    ->whereDate('discounts.discount_start', '<=', now())
                    ->whereDate('discounts.discount_end', '>=', now());
            },
        ]);

        if (!empty($category)) {
            $query->whereHas('product.category', function ($query) use ($category) {
                $query->where('name', $category);
            });
        }

        if (!empty($brand)) {
            $query->whereHas('product.brand', function ($query) use ($brand) {
                $query->whereIn('name', $brand);
            });; 
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
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }
}
