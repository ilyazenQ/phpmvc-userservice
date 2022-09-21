<?php

namespace App\Services\Equipment;

use App\Services\Validator;

class ValidateService implements Validator
{
    public function validate()
    {
        if (!$_POST('title'))
        {
            return false;
        }
        return true;
    }
}