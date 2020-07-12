<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use App\Repositories\ProductRepository;

class ProductService{

    protected $productRepository;

    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }


    /**
     * 
     * Get every single user
     * 
     */
    public function getAllProducts(){
        return $this->productRepository->getAll();
    }
    
    /**
     * 
     * Get every single user
     * 
     */
    public function getAllProductsWithFormattedPrices(){
        // added price Formatted with RP.
        return $this->productRepository->getAll()->transform(function($item){
            $item->product_formatted_price = $this->formatToRupiah($item->product_price) ;
            $item->orders->transform(function($order){
                $order->formatted_total = $this->formatToRupiah($order->total) ;
                return $order;
            });
            return $item;
        });
    }
    
    /**
     * 
     * Get one user with given id
     * 
     */
    public function getOneByIdWithFormattedPrices($id){
        // Add RP to prices
        $product = $this->productRepository->getOneById($id);
        $product->product_formatted_price = $this->formatToRupiah($product->product_price) ;
        $product->orders->transform(function($order){
            $order->formatted_total = $this->formatToRupiah($order->total) ;
            return $order;
        });
        return $product;
    }


    /**
     * 
     * Get one user with given id
     * 
     */
    public function getOneById($id){
        return $this->productRepository->getOneById($id);
    }

    /**
     * 
     * Validate and save create a new user
     * 
     */
    public function saveProduct($product){
        // start the databse transaction
        DB::beginTransaction();

        try{
            // process the image
            $product['product_image_url'] = $this->uploadFile($product);

            // $fileName;
            // try to create the user
            $createdProduct = $this->productRepository->save($product);
            
            // commit the databse transcation
            DB::commit();

            // Return created user to controller
            return $createdProduct;
        }catch(Exception $e){
            // Undo any Database transaction
            DB::rollback();

            // return the error
            throw new InvalidArgumentException($e);
        }
    }

    public function updateProduct($product,$id){
        // start the databse transaction
        DB::beginTransaction();

        try{
            // Process uploaded image
            $product['product_image_url'] = false;
            if ($product->hasFile('product_image')) {
                $product['product_image_url'] = $this->uploadFile($product);
            }

            // try to update the user
            $updatedProduct = $this->productRepository->update($product, $id);
            
            // commit the databse transcation
            DB::commit();

            // Return updated user to controller
            return $updatedProduct;
        }catch(Exception $e){
            // Undo any Database transaction
            DB::rollback();

            // return the error
            throw new InvalidArgumentException($e);
        }
    }

    /**
     * 
     * Deactivate one User
     * 
     */
    public function softDeleteProduct($id){

        // start the databse transaction
        DB::beginTransaction();

        try{
            // try to soft delete the user
            $this->productRepository->softDelete($id);
            
            // commit the databse transcation
            DB::commit();

            // Return created user to controller
            return true;
        }catch(Exception $e){
            // Undo any Database transaction
            DB::rollback();

            // return the error
            throw new InvalidArgumentException($e);
        }
    }

    /**
     * 
     * Permanently delete one User
     * 
     */
    public function hardDeleteProduct(){
        //process one entity
    }

    /**
     * 
     * Recover one User
     * 
     */
    public function recoverProduct(){
        //process one entity
    }

    /**
     * 
     * Deactivate multiple User
     * 
     */
    public function bulkSoftDeleteProduct(){
        // Process multiple entity
    }
    
    /**
     * 
     * Permanentlu delete multiple User
     * 
     */
    public function bulkHardDeleteProduct(){
        // Process multiple entity
    }
    
    /**
     * 
     * Recover multiple User
     * 
     */
    public function bulkRecoverProduct(){
        // Process multiple entity       
    }

    // Format given value to Rupiah
    public function formatToRupiah(Int $money){
        return "Rp. ". number_format($money, 0, ',', '.');
    }

    /**
     * 
     * For file upload
     * 
     */
    public function uploadFile($file, $storage = "/public"){
        $extension = $file->product_image->extension();
        $fileName =  Str::slug(time().$file->product_image->getClientOriginalName()).".".$extension;
        $file->product_image->storeAs($storage ,$fileName);            
        return $file->root().Storage::url($fileName);
    }

}
