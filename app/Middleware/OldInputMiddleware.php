<?php
/**
 * Created by PhpStorm.
 * User: ermolaev
 * Date: 11.12.2020
 * Time: 11:51
 */
namespace App\Middleware;

class OldInputMiddleware extends Middleware{

    public function __invoke($request, $response, $next)
    {

        $this->container->view->getEnvironment()->addGlobal('old',$_SESSION['old']);

        $_SESSION['old'] = $request->getParams();

        $response = $next($request,$response);

        return $response;
    }
}