<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository{
    protected $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function getAll(){
        return $this->user->get();
    }

    public function getOneById($id){
        return $this->user->findOrFail($id);
    }
    
    public function save($data){
        // create new user instance
        $user = new $this->user;

        // Populate the data
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);

        // Save to databse
        $user->save();

        // return saved data
        return $user->fresh();
    }

    public function update($data,$id){
        // Get user from given ID
        $user = $this->getOneById($id);
        
        // Populate with new data
        $user->name = $data['name'];
        $user->email = $data['email'];
        if($data['password']){
            $user->password = Hash::make($data['password']);
        }

        // save and return with newly updated data
        $user->save();
        return $user->fresh();

    }

    public function delete(){

    }

    public function softDelete($id){
        // find the user
        $user = $this->getOneById($id);

        $user->delete();

        return true;
    }

    public function recover(){

    }
}
