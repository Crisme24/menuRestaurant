<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'price',
        'description',
        'image_path',
        'stock'
    ];

    protected $casts = [
         //'size' => 'array',
    ];

    public function categories()
    {
        return $this->belongsToMany('\App\Category');
    }
}
