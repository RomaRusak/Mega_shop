<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;

    protected $tables   = 'galleries';
    protected $fillable = ['image_paths'];

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
}
