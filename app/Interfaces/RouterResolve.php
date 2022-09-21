<?php 
namespace App\Interfaces;

interface RouterResolve {

   public function resolve(string $requestUri,string $requestMethod);

}
