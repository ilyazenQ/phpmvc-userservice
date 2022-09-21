<?php

namespace App\Permissions;

class AuthPermission
{
    static function check()
    {
        if(!isset($_COOKIE['user'])) {
            return false;
        }
        return true;
    }
}