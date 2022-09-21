<?php

namespace App\Actions;

use App\Models\User;

class StoreUserAction
{
    static function execute($data)
    {
        $user = new User();
        $user->store($data);
    }
}