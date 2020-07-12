<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    //
    use SoftDeletes;
    
    
    protected $fillable = [
        'product_name',
        'product_price',
        'product_image',
        'product_code',
    ];

    /**
     * get the orders belognst to this product
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order')->withTrashed();
    }
}
