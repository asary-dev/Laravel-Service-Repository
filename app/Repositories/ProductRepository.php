<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class productRepository{
    protected $product;

    public function __construct(product $product){
        $this->product = $product;
    }

    public function getAll(Request $request){
        return $this->product->get();
    }

    public function getOneById($id){
        return $this->product->findOrFail($id);
    }
    
    public function save($data){
        // create new product instance
        $product = new $this->product;

        // Populate the data
        $product->product_code = $data['product_code'];
        $product->product_name = $data['product_name'];
        $product->product_price = $data['product_price'];
        $product->product_image = $data['product_image_url'];

        // Save to databse
        $product->save();

        // return saved data
        return $product->fresh();
    }

    public function update($data,$id){
        // Get product from given ID
        $product = $this->getOneById($id);
        
        // Populate with new data
        $product->product_code = $data['product_code'];
        $product->product_name = $data['product_name'];
        $product->product_price = $data['product_price'];
        
        if($data['product_image_url'] != false){
            $product->product_image = $data['product_image_url'];
        }

        // save and return with newly updated data
        $product->save();
        return $product->fresh();

    }

    public function delete(){

    }

    public function softDelete($id){
        // find the product
        $product = $this->getOneById($id);

        $product->delete();
        $product->orders()->delete();

        return true;
    }

    public function recover(){

    }
}
