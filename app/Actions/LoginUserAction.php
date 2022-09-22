<?php

namespace App\Actions;

use App\App;
use App\Services\User\Actions\SanitizeInputLoginDataAction;
use App\Services\User\ValidateUserLoginService;

class LoginUserAction
{
    public function __construct()
    {
        $this->db = App::db();
    }

    public function execute()
    {
        $data = SanitizeInputLoginDataAction::execute();
        $field = (new ValidateUserLoginService())->getInputField();
        $phoneFromDbQuery = $this->db->query("SELECT * FROM users WHERE $field = " ."'".$data['field']."'");

        $user = $phoneFromDbQuery->fetch();
        setcookie('user', $user['id'], time() + 3600, "/");
        return $user;
    }
}