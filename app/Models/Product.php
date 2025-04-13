<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

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
}
