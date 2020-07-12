<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class OrderRepository{
    protected $order;

    public function __construct(Order $order){
        $this->order = $order;
    }

    public function getAll(){
        return $this->order->get();
    }

    public function getOneById($id){
        return $this->order->findOrFail($id);
    }
    
    public function save($data){
        // create new order instance
        $order = new $this->order;

        // Populate the data
        $order->customer_name = $data['customer_name'];
        $order->customer_phone = $data['customer_phone'];
        $order->customer_address = $data['customer_address'];
        $order->quantity = $data['quantity'];
        $order->total = $data['total'];
        $order->product_id = $data['product_id'];

        // Save to databse
        $order->save();

        // return saved data
        return $order->fresh();
    }

    public function update($data,$id){
        // Get order from given ID
        $order = $this->getOneById($id);
        
        // Populate with new data
        $order->customer_name = $data['customer_name'];
        $order->customer_phone = $data['customer_phone'];
        $order->customer_address = $data['customer_address'];
        $order->quantity = $data['quantity'];
        $order->total = $data['total'];
        $order->product_id = $data['product_id'];

        // save and return with newly updated data
        $order->save();
        return $order->fresh();

    }

    public function delete(){

    }

    public function softDelete($id){
        // find the order
        $order = $this->getOneById($id);

        $order->delete();

        return true;
    }

    public function recover(){

    }
}
