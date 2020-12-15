<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 13.12.2020
 * Time: 17:16
 */

namespace App\Middleware;

class AdminCheckMiddleware extends Middleware{
    public function __invoke($request, $response, $next)
    {
        $this->container->view->getEnvironment()->addGlobal('role',$_SESSION['role']);

        if($_SESSION['user']['role'] != 'admin'){
            return $response;
        }

        $response = $next($request,$response);

        return $response;
    }
}