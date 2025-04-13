<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserApi extends Model
{
    use SoftDeletes;

    protected $table    = 'users_api';
    protected $fillable = ['user_id', 'is_admin'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
