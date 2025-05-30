<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $tables   = 'galleries';
    protected $fillable = ['image_paths'];

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
}
