<?php

namespace App\Actions;

use App\Models\User;

class UpdateUserAction
{
    static function execute($data, $id)
    {
        $user = new User();
        $user->update($data, $id);
    }
}