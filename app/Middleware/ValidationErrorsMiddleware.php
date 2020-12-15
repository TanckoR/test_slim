<?php
/**
 * Created by PhpStorm.
 * User: ermolaev
 * Date: 11.12.2020
 * Time: 10:35
 */

namespace App\Middleware;

class ValidationErrorsMiddleware extends Middleware{

    public function __invoke($request, $response, $next)
    {
        $this->container->view->getEnvironment()->addGlobal('errors',$_SESSION['errors']);

        unset($_SESSION['errors']);

        $response = $next($request,$response);

        return $response;
    }
}