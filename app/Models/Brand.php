<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Traits\GetUniqValuesArr;

class Brand extends Model
{
    use HasFactory, SoftDeletes, GetUniqValuesArr;
    
    protected $table    = 'brands';
    protected $fillable = ['name'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
