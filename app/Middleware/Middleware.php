<?php
/**
 * Created by PhpStorm.
 * User: ermolaev
 * Date: 11.12.2020
 * Time: 10:17
 */

namespace App\Middleware;

class Middleware{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
}