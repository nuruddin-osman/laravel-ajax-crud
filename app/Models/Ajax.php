<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ajax extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
    ];
}
