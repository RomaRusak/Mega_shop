<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserApi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table    = 'users_api';
    protected $fillable = ['user_id', 'is_admin'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
