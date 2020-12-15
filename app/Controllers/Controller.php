<?php
/**
 * Created by PhpStorm.
 * User: ermolaev
 * Date: 10.12.2020
 * Time: 14:12
 */

namespace App\Controllers;


class Controller{

    protected $container;

   public function __construct($container)
   {
       $this->container = $container;
   }

    public function __get($property){
       if($this->container->{$property}){
           return $this->container->{$property};
       }
    }
}