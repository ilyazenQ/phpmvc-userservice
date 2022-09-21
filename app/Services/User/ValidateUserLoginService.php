<?php

namespace App\Services\User;

use App\App;
use App\Services\User\Actions\SanitizeInputLoginDataAction;
use App\Services\Validator;

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

    private function checkIfUserExists()
    {
        $phoneFromDbQuery = $this->db->query('SELECT * FROM `users` WHERE `phone` = ' . $this->data['phone']);
        if (empty($phoneFromDbQuery->fetch())) {
            $this->message = 'Пользователя не существует';
            $this->status = false;
        }
    }
    private function checkPassword()
    {
        $phoneFromDbQuery = $this->db->query('SELECT * FROM `users` WHERE `phone` = ' . $this->data['phone']);
        $user = $phoneFromDbQuery->fetch();
        if($user['password'] !== md5($this->data['password'])) {
            $this->message = 'Не верный пароль';
            $this->status = false;
        }
    }

    public function validate()
    {
        $this->checkRecaptcha();

        if ($this->status === false) {
            return [
                'message'=>$this->message,
                'status' => $this->status,
            ];
        }

        $this->checkIfUserExists();

        if ($this->status === false) {
            return [
                'message'=>$this->message,
                'status' => $this->status,
            ];
        }

        $this->checkPassword();

        if ($this->status === false) {
            return [
                'message'=>$this->message,
                'status' => $this->status,
            ];
        }

        return [
            'message'=>$this->message,
            'status' => $this->status,
        ];
    }
}