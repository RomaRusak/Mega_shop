<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Helpers\GeneralHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    = 'products';
    protected $fillable = ['name', 'description', 'brand_id', 'category_id', 'rating'];

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

    public function getFilProductsQuery(array $preparedRequestParams): Builder
    {
        $transformedBrand    = array_map(function($brand) {
            return strtolower(GeneralHelper::underscoresToSpace($brand));
        }, $preparedRequestParams['brand']);
        
        $color               = $preparedRequestParams['color'];
        $size                = $preparedRequestParams['size'];
        $minPrice            = $preparedRequestParams['min_price'];
        $maxPrice            = $preparedRequestParams['max_price'];
        $transformedcategory = strtolower(GeneralHelper::underscoresToSpace($preparedRequestParams['category']));

        $query = $this->withProductRelations(
            $this::select('id', 'name', 'brand_id', 'category_id', 'rating')
        );

        if (!empty($transformedcategory)) {
            $query->whereHas('category', function ($query) use ($transformedcategory) {
                $query->where(DB::raw('LOWER(name)'), $transformedcategory);
            });
        }

        if (!empty($transformedBrand)) {
            $query->whereHas('brand', function ($query) use ($transformedBrand) {
                $query->whereIn(DB::raw('LOWER(name)'), $transformedBrand);
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
        
        if (!empty($minPrice)) {
            $query->whereHas('productVariants', function ($query) use ($minPrice) {
                $query->where('price', '>=', $minPrice)
                      ->where('quantity', '>', 0);
            });
        }
        
        if (!empty($maxPrice)) {
            $query->whereHas('productVariants', function ($query) use ($maxPrice) {
                $query->where('price', '<=', $maxPrice)
                      ->where('quantity', '>', 0);
            });
        }

        return $query;
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
                $query->select('id', 'name');
            },

            'productVariants.discounts' => function($query) {
                $query->select('discounts.id', 'discounts.discount_percent', 'discounts.discount_start', 'discounts.discount_end')
                    ->whereDate('discounts.discount_start', '<=', now())
                    ->whereDate('discounts.discount_end', '>=', now());
            },
        ]);
    }

    public function getProductById(string $id): Collection
    {
        return $this->withProductRelations(
            $this::select('id', 'name', 'brand_id', 'category_id', 'rating')
            ->where('id', $id)
        )->get();
    }
}
