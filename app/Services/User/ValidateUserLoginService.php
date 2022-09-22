<?php

namespace App\Services\User;

use App\App;
use App\Services\User\Actions\SanitizeInputLoginDataAction;
use App\Services\Validator;
use Exception;

class ValidateUserLoginService implements Validator
{
    private $message = 'all valid';
    private $status = true;

    public function __construct()
    {
        $this->data = SanitizeInputLoginDataAction::execute();
        $this->db = App::db();
    }

    private function checkRecaptcha()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {

            $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
            $recaptcha_secret = '6Le7CxciAAAAAB5n7PF1obs_OAYXi74mBf4rVWSA';
            $recaptcha_response = $_POST['recaptcha_response'];

            $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
            $recaptcha = json_decode($recaptcha);

            if ($recaptcha->score <= 0.5) {
                $this->message = 'Это бот';
                $this->status = false;
            }

        }
    }

    private function checkIfUserExists($field)
    {
        $phoneFromDbQuery = $this->db->query("SELECT * FROM users WHERE $field = " ."'".$this->data['field']."'");
        if (empty($phoneFromDbQuery->fetch())) {
            $this->message = 'Пользователя не существует';
            $this->status = false;
        }
    }

    private function checkPassword($field)
    {
        $phoneFromDbQuery = $this->db->query("SELECT * FROM users WHERE $field = " ."'".$this->data['field']."'");
        $user = $phoneFromDbQuery->fetch();
        if ($user['password'] !== md5($this->data['password'])) {
            $this->message = 'Не верный пароль';
            $this->status = false;
        }
    }

    public function getInputField()
    {
        if (filter_var($this->data['field'], FILTER_VALIDATE_EMAIL)) {
            return 'email';
        } else {
            return 'phone';
        }
    }

    public function validate()
    {
        $this->checkRecaptcha();

        if ($this->status === false) {
            return [
                'message' => $this->message,
                'status' => $this->status,
            ];
        }


        $this->checkIfUserExists($this->getInputField());

        if ($this->status === false) {
            return [
                'message' => $this->message,
                'status' => $this->status,
            ];
        }

        $this->checkPassword($this->getInputField());

        if ($this->status === false) {
            return [
                'message' => $this->message,
                'status' => $this->status,
            ];
        }

        return [
            'message' => $this->message,
            'status' => $this->status,
        ];
    }
}