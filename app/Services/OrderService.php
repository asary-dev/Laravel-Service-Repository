<?php

namespace App\Services;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Repositories\OrderRepository;

class OrderService{

    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository){
        $this->orderRepository = $orderRepository;
    }    

    /**
     * 
     * Get every single order
     * 
     */
    public function getAllOrders(Request $requests){
        return $this->orderRepository->getAll($requests);
    }
    
    
    /**
     * 
     * Get every single user
     * 
     */
    public function getAllOrdersWithFormattedPrices(Request $requests){
        // added price Formatted with RP.
        return $this->orderRepository->getAll($requests)->transform(function($item){
            $item->formatted_total = $this->formatToRupiah($item->total);
            error_log($item->product_detail);
            $item->product_detail->product_formatted_price = $this->formatToRupiah($item->product_detail->product_price);
            return $item;
        });
    }
    
    /**
     * 
     * Get one user with given id
     * 
     */
    public function getOneByIdWithFormattedPrices($id){
        $order = $this->orderRepository->getOneById($id);
        $order->formatted_total = $this->formatToRupiah($order->total);
        $order->product_detail->product_formatted_price = $this->formatToRupiah($order->product_detail->product_price);
        return $order;
    }

    /**
     * 
     * Get one order with given id
     * 
     */
    public function getOneById($id){
        return $this->orderRepository->getOneById($id);
    }

    /**
     * 
     * Validate and save create a new order
     * 
     */
    public function saveOrder($order){
        // start the databse transaction
        DB::beginTransaction();

        try{
            // try to create the order
            $createdOrder = $this->orderRepository->save($order);
            
            // commit the databse transcation
            DB::commit();

            // Return created order to controller
            return $createdOrder;
        }catch(Exception $e){
            // Undo any Database transaction
            DB::rollback();

            // return the error
            throw new InvalidArgumentException($e);
        }
    }

    public function updateOrder($data,$id){
        // start the databse transaction
        DB::beginTransaction();

        try{
            // try to update the order
            $updatedorder = $this->orderRepository->update($data, $id);
            
            // commit the databse transcation
            DB::commit();

            // Return updated order to controller
            return $updatedorder;
        }catch(Exception $e){
            // Undo any Database transaction
            DB::rollback();

            // return the error
            throw new InvalidArgumentException($e);
        }
    }

    /**
     * 
     * Deactivate one order
     * 
     */
    public function softDeleteOrder($id){

        // start the databse transaction
        DB::beginTransaction();

        try{
            // try to soft delete the order
            $this->orderRepository->softDelete($id);
            
            // commit the databse transcation
            DB::commit();

            // Return created order to controller
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
     * Permanently delete one order
     * 
     */
    public function hardDeleteOrder(){
        //process one entity
    }

    /**
     * 
     * Recover one order
     * 
     */
    public function recoverOrder(){
        //process one entity
    }

    /**
     * 
     * Deactivate multiple order
     * 
     */
    public function bulkSoftDeleteOrder(){
        // Process multiple entity
    }
    
    /**
     * 
     * Permanentlu delete multiple order
     * 
     */
    public function bulkHardDeleteOrder(){
        // Process multiple entity
    }
    
    /**
     * 
     * Recover multiple order
     * 
     */
    public function bulkRecoverOrder(){
        // Process multiple entity       
    }

    
    // Format given value to Rupiah
    public function formatToRupiah(Int $money){
        return "Rp. ". number_format($money, 0, ',', '.');
    }
}
