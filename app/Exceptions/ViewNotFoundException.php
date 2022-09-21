<?php

namespace App\Exceptions;

class ViewNotFoundException extends \Exception
{
    protected $message = 'VIEW NOT FOUND';
}