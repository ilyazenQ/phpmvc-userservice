<?php

namespace App\Controllers;

use App\Actions\LoginUserAction;
use App\Actions\StoreUserAction;
use App\Actions\UpdateUserAction;
use App\Models\User;
use App\Permissions\AuthPermission;
use App\Services\User\Actions\SanitizeInputDataAction;
use App\Services\User\ValidateService;
use App\Services\User\ValidateUpdateService;
use App\Services\User\ValidateUserLoginService;
use App\View;

class UserController
{
    public function index()
    {
        $message = 'Войдите или зарегистрируйтесь';
        return View::make('user/main', [
            'message' => $message,
        ])->render(true);
    }

    public function create()
    {
        $message = 'Заполните все поля для регистрации';
        return View::make('user/reg', [
            'message' => $message,
        ])->render(true);
    }

    public function store()
    {
        $validateResult = (new ValidateService())->validate();

        if ($validateResult['status'] == false) {
            $message = $validateResult['message'];
            return View::make('user/reg', [
                'message' => $message,
            ])->render(true);
        }

        $data = SanitizeInputDataAction::execute();
        StoreUserAction::execute($data);
        $message = 'Регистрация прошла успешно';
        return View::make('user/main', [
            'message' => $message,
        ])->render(true);
    }

    public function auth()
    {
        $message = 'Войдите используя телефон и пароль';
        return View::make('user/auth', [
            'message' => $message,
        ])->render(true);
    }

    public function update()
    {
        if (!AuthPermission::check()) {
            $message = 'Только зарегистрированный пользователь может изменять профиль';
            return View::make('user/main', [
                'message' => $message,
            ])->render(true);
        }
        $currentUser = (new User())->getAuthUser();
        $message = 'Измените профиль';
        return View::make('user/update', [
            'message' => $message,
            'user'=>$currentUser,
        ])->render(true);
    }

    public function upgrade()
    {
        if (!AuthPermission::check()) {
            $message = 'Только зарегистрированный пользователь может изменять профиль';
            return View::make('user/main', [
                'message' => $message,
            ])->render(true);
        }

        $currentUser = (new User())->getAuthUser();
        $validateResult = (new ValidateUpdateService($currentUser))->validate();

        if ($validateResult['status'] == false) {
            $message = $validateResult['message'];
            return View::make('user/update', [
                'message' => $message,
                'user'=>$currentUser,
            ])->render(true);
        }

        $data = SanitizeInputDataAction::execute();
        UpdateUserAction::execute($data, $currentUser['id']);
        $message = 'Данные успешно обновлены';
        return View::make('user/update', [
            'message' => $message,
            'user'=>$currentUser,
        ])->render(true);

    }

    public function login()
    {
        $validateResult = (new ValidateUserLoginService())->validate();

        if ($validateResult['status'] == false) {
            $message = $validateResult['message'];
            return View::make('user/auth', [
                'message' => $message,
            ])->render(true);
        }
        $user = (new LoginUserAction())->execute();

        header('Location: /');
    }

    public function check()
    {
        echo "200 OK";
    }
}