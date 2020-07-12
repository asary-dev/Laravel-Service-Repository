<?php

namespace App\Services;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;

use App\Repositories\UserRepository;

class UserService{

    protected $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    

    /**
     * 
     * Get every single user
     * 
     */
    public function getAllUsers(){
        return $this->userRepository->getAll();
    }
    
    /**
     * 
     * Validate and save create a new user
     * 
     */
    public function getAllUsersPaginated(){
        // N.A
    }

    /**
     * 
     * Get one user with given id
     * 
     */
    public function getOneById($id){
        return $this->userRepository->getOneById($id);
    }

    /**
     * 
     * Validate and save create a new user
     * 
     */
    public function saveUser($user){
        // start the databse transaction
        DB::beginTransaction();

        try{
            // try to create the user
            $createdUser = $this->userRepository->save($user);
            
            // commit the databse transcation
            DB::commit();

            // Return created user to controller
            return $createdUser;
        }catch(Exception $e){
            // Undo any Database transaction
            DB::rollback();

            // return the error
            throw new InvalidArgumentException($e);
        }
    }

    public function updateUser($data,$id){
        // start the databse transaction
        DB::beginTransaction();

        try{
            // try to update the user
            $updatedUser = $this->userRepository->update($data, $id);
            
            // commit the databse transcation
            DB::commit();

            // Return updated user to controller
            return $updatedUser;
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
    public function softDeleteUser($id){

        // start the databse transaction
        DB::beginTransaction();

        try{
            // try to soft delete the user
            $createdUser = $this->userRepository->softDelete($id);
            
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
    public function hardDeleteUser(){
        //process one entity
    }

    /**
     * 
     * Recover one User
     * 
     */
    public function recoverUser(){
        //process one entity
    }

    /**
     * 
     * Deactivate multiple User
     * 
     */
    public function bulkSoftDeleteUser(){
        // Process multiple entity
    }
    
    /**
     * 
     * Permanentlu delete multiple User
     * 
     */
    public function bulkHardDeleteUser(){
        // Process multiple entity
    }
    
    /**
     * 
     * Recover multiple User
     * 
     */
    public function bulkRecoverUser(){
        // Process multiple entity       
    }

}
