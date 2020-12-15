<?php
/**
 * Created by PhpStorm.
 * User: ermolaev
 * Date: 11.12.2020
 * Time: 12:42
 */

namespace App\Auth;

use App\Models\User;

class Auth
{
    public function user(){
        return User::find($_SESSION['user']);
    }

    public function check(){
        return isset($_SESSION['user']);
    }

    public function checkAdmin(){
        if($_SESSION['role']=='admin'){
            return $this->user();
        }
        return false;
    }

    public function attmpt($email,$password){

        $user = User::where('email',$email)->first();

        if(!$user){
            return false;
        }

        if(password_verify($password,$user->password)){
            $_SESSION['user'] = ['user'=>$user->id,'role'=>$user->role];
            User::where('id',$user->id)->update(['session'=>session_id()]);

            return true;
        }

        return false;
    }

    public function logout(){
        $userDB = User::where('id',$_SESSION['user']['user'])->update(['session'=> Null]);
        unset($_SESSION['user']);
    }
}