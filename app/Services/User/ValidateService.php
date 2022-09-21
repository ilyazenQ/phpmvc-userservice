<?php

namespace App\Services\User;

use App\App;
use App\Services\User\Actions\SanitizeInputDataAction;
use App\Services\Validator;

class ValidateService implements Validator
{
    protected $message = 'all valid';
    protected $status = true;

    public function __construct()
    {
        $this->db = App::db();
    }

    protected function checkIfAllInputFields()
    {
        if (
            !$_POST['name'] ||
            !$_POST['phone'] ||
            !$_POST['email'] ||
            !$_POST['password'] ||
            !$_POST['password-confirm']) {
            $this->message = 'Заполните все поля';
            $this->status = false;
            return false;
        }
    }

    protected function checkPasswords()
    {
        if ($_POST['password'] != $_POST['password-confirm']) {
            $this->message = 'Пароли не совпадают';
            $this->status = false;
        }
    }

    protected function checkIfFieldAlreadyExist($data, $fieldName)
    {
        $fromDbQuery = $this->db->query('SELECT * FROM `users` WHERE `name` = ' . $data[$fieldName]);
        if (!empty($fromDbQuery->fetch())) {
            $this->message = 'Пользователь с такими полями уже зарегистрирован';
            $this->status = false;
        }
    }

    protected function checkIfInputFieldsAlreadyExists()
    {
        $data = SanitizeInputDataAction::execute();

        foreach ($data as $key => $value) {
            if ($key === 'password' || $key === 'password-confirm') {
                continue;
            }
            $this->checkIfFieldAlreadyExist($data, $key);
        }

    }

    public function validate()
    {
        $this->checkIfAllInputFields();

        if ($this->status === false) {
            return [
                'message' => $this->message,
                'status' => $this->status,
            ];
        }

        $this->checkPasswords();

        if ($this->status === false) {
            return [
                'message' => $this->message,
                'status' => $this->status,
            ];
        }

        $this->checkIfInputFieldsAlreadyExists();

        return [
            'message' => $this->message,
            'status' => $this->status,
        ];
    }
}