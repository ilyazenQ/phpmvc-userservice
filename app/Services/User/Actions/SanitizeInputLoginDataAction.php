<?php

namespace App\Services\User\Actions;

class SanitizeInputLoginDataAction
{
    static function execute()
    {
        return [
            'field' => filter_var(trim($_POST['phone']), FILTER_SANITIZE_STRING),
            'password' => filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING),
        ];
    }
}