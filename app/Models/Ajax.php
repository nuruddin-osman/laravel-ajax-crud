<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ajax extends Model
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'price',
        'category',
        'quantity',
        'discount',
        'status',
        'featured',
        'trending',
        'meta_title',
        'meta_keyword',
        'meta_description',
    ];
}
