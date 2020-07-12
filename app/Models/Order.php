<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    //
    use SoftDeletes;
    
    protected $fillable = [
        'customer_name',
        'customer_address',
        'customer_phone',
        'quantity',
        'total',
        'product_id'
    ];

    /**
     * get the product this order belongs to
     */
    public function product_detail()
    {
        return $this->belongsTo('App\Models\Product',"product_id")->withTrashed();
    }
}
