<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Shortlink extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'original_url',
        'custom_code',
        'user_id',
        'clicks'
    ];


    /**
     * Get the user that own the link.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}