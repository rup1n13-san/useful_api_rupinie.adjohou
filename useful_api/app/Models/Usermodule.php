<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usermodule extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'module_id',
        'active',
    ];

    /**
     * Get the user associated with the usermodule.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
    /**
     * Get the module associated with the usermodule.
     */
    public function module(): HasOne
    {
        return $this->hasOne(Module::class);
    }
}