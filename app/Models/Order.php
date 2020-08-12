<?php

namespace App\Models;
use Carbon\Carbon;
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

    public function scopeFilter($query,$requests)
    {
        if($requests->has("from") || $requests->has("to")){       
            // if from is empty it will set to 30 days ago
            $from = $requests->get("from") ? Carbon::parse($requests->get("from"))->toDateTimeString() : Carbon::now()->subDays(30)->toDateTimeString();
            // if to is empty it will set to 15 days from now
            $to = $requests->get("to") ? Carbon::parse($requests->get("to"))->toDateTimeString() : Carbon::now()->addDays(15)->toDateTimeString();
            $query->whereBetween('created_at', [$from, $to]);
        }
        return $query;
    }
}
