<?php

namespace App\Actions;

use App\App;
use App\Services\User\Actions\SanitizeInputLoginDataAction;

class LoginUserAction
{
    public function __construct()
    {
        $this->db = App::db();
    }

    public function execute()
    {
        $data = SanitizeInputLoginDataAction::execute();
        $phoneFromDbQuery = $this->db->query('SELECT * FROM `users` WHERE `phone` = ' . $data['phone']);
        $user = $phoneFromDbQuery->fetch();
        setcookie('user', $user['id'], time() + 3600, "/");
        return $user;
    }
}