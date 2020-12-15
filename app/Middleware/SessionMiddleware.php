<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 13.12.2020
 * Time: 17:52
 */

namespace App\Middleware;

class SessionMiddleware extends Middleware{

    public function __invoke($request, $response, $next)
    {


        if($_SESSION['user']){
            if($_COOKIE['user']){
                unset($_COOKIE['user']);
                setcookie('user',$_SERVER["REMOTE_ADDR"],time()+3600);//срок жизни куки час
            }

        }else{

            $_SESSION['user'] = $_SERVER['REMOTE_ADDR'];
            setcookie('user',$_SERVER["REMOTE_ADDR"],time()+3600);//срок жизни куки час
        }

        $response = $next($request,$response);

        return $response;
    }

}