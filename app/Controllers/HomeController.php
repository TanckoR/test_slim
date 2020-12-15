<?php
/**
 * Created by PhpStorm.
 * User: ermolaev
 * Date: 10.12.2020
 * Time: 14:03
 */

namespace App\Controllers;

use App\Models\User;


class HomeController extends Controller
{
    public function index($request,$response){
//        $user = User::where('email','vlad_ermolaev@inbox.ru')->first();
//var_dump($user->username);

//        User::create(['username' => 'test1','email' => "a@test.com",'password' => '123456','role' => 'user']);

        return $this->view->render($response,'home.twig');
    }
}