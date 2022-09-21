<?php
namespace App\Exceptions;

class RouteNotFoundException extends \Exception 
{
   protected $message = 'ROUTE NOT FOUND';
}