<?php

namespace App\Services\User;

use App\Services\User\Actions\SanitizeInputDataAction;

class ValidateUpdateService extends ValidateService
{
    protected $currentUserData;
    public function __construct(
        $currentUserData
    )
    {
        $this->currentUserData = $currentUserData;
        parent::__construct();
    }
    protected function checkIfFieldAlreadyExist($data, $fieldName)
    {
        if($data[$fieldName] != $this->currentUserData[$fieldName]) {
            $fromDbQuery = $this->db->query('SELECT * FROM `users` WHERE `name` = ' . $data[$fieldName]);
            if (!empty($fromDbQuery->fetch())) {
                $this->message = 'Пользователь с такими полями уже зарегистрирован';
                $this->status = false;
            }
        }
    }


}