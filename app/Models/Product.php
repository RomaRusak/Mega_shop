<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    = 'products';
    protected $fillable = ['name', 'slug', 'description', 'brand_id', 'category_id', 'rating'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    
    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews():HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getFilteredProducts(array $preparedRequestParams): Collection
    {
        $color               = $preparedRequestParams['color'];
        $size                = $preparedRequestParams['size'];
        // $minPrice            = $preparedRequestParams['min_price'];
        // $maxPrice            = $preparedRequestParams['max_price'];
        $categorySlug        = $preparedRequestParams['categorySlug'];
        $brandSlug           = $preparedRequestParams['brand'];

        $query = $this->withProductRelations(
            $this::select('id', 'name', 'slug', 'brand_id', 'category_id', 'rating')
        );

        if (!empty($categorySlug)) {
            $query->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug);
            });
        }

        if (!empty($brandSlug)) {
            $query->whereHas('brand', function ($query) use ($brandSlug) {
                $query->whereIn('slug', $brandSlug);
            });
        }
        
        if (!empty($color)) {
            $query->whereHas('productVariants', function ($query) use ($color) {
                $query->whereIn('color', $color)
                      ->where('quantity', '>', 0);
            });
        }
        
        if (!empty($size)) {
            $query->whereHas('productVariants', function ($query) use ($size) {
                $query->whereIn('size', $size)
                      ->where('quantity', '>', 0);
            });
        }
        
        // if (!empty($minPrice)) {
        //     $query->whereHas('productVariants', function ($query) use ($minPrice) {
        //         $query->where('price', '>=', $minPrice)
        //               ->where('quantity', '>', 0);
        //     });
        // }
        
        // if (!empty($maxPrice)) {
        //     $query->whereHas('productVariants', function ($query) use ($maxPrice) {
        //         $query->where('price', '<=', $maxPrice)
        //               ->where('quantity', '>', 0);
        //     });
        // }

        return $query->get();
    }

    private function withProductRelations(Builder $query): Builder
    {
        return $query->with([
            'productVariants' => function ($query) {
                $query->select('id', 'size', 'color', 'product_id', 'gallery_id', 'price', 'quantity');
            },

            'productVariants.gallery' => function ($query) {
                $query->select('id', 'image_paths');
            },

            'brand' => function ($query) {
                $query->select('id', 'name');
            },

            'category' => function ($query) {
                $query->select('id', 'name', 'slug');
            },

            'productVariants.discounts' => function($query) {
                $query->select('discounts.id', 'discounts.discount_percent', 'discounts.discount_start', 'discounts.discount_end')
                    ->whereDate('discounts.discount_start', '<=', now())
                    ->whereDate('discounts.discount_end', '>=', now());
            },
        ]);
    }

    
    public function getProductById(string $id): Product
    {
        return $this->withProductRelations(
            $this::select('id', 'name', 'description', 'brand_id', 'category_id', 'rating')
        )
        ->with(['reviews' => function($query) {
            $query->select('id', 'product_id', 'user_id', 'review_text', 'rating', 'created_at', 'review_date')
                  ->with(['user' => function($query) {
                        $query->select('id', 'name',);
                  }]);
        }])
        ->find($id);   
    }
}
