<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use  HasFactory, SoftDeletes;

    protected $table    = 'discounts';
    protected $fillable = ['discount_percent', 'discount_start', 'discount_end'];

    public function productVariants(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class, 'discount_product_variant', 'discount_id', 'product_variant_id');
    }
}
