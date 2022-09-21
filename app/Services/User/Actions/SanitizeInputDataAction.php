<?php

namespace App\Services\User\Actions;

class SanitizeInputDataAction
{
    static function execute()
    {
        return [
            'name' => filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING),
            'email' => filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING),
            'phone' => filter_var(trim($_POST['phone']), FILTER_SANITIZE_STRING),
            'password' => filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING),
            'password-confirm' => filter_var(trim($_POST['password-confirm']), FILTER_SANITIZE_STRING),
        ];
    }
}