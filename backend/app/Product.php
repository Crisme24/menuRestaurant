<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'address',
        'telephone',
        'image_path'
    ];

    protected $casts = [
         //
    ];

    public function categories()
    {
        return $this->belongsToMany('\App\Category');
    }
}
