<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscountProductVariant extends Model
{
    use  HasFactory, SoftDeletes;

    protected $table    = 'discount_product_variant';
    protected $fillable = ['discount_id', 'product_variant_id'];
}
