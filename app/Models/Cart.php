<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    = 'carts';
    protected $fillable = ['user_id', 'cart_contains'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
