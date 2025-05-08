<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Helpers\GeneralHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\GetUniqValuesArr;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes, GetUniqValuesArr;

    protected $table       = 'product_variants';
    protected $fillable    = ['product_id', 'gallery_id', 'size', 'color', 'quantity', 'price'];

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

    public function getProdVarWithDiscounts()
    {
        return $this->with('discounts')->get()->toArray();
    }
}
