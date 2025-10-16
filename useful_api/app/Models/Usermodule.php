<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}