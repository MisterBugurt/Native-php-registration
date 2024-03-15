<?php

namespace MyProject\Controllers;

use MyProject\Exception\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UsersAuthService;


class UsersController extends AbstractController
{

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $exception) {
                $this->view->renderHtml('users/login.php', ['error' => $exception->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }

    public function logout()
    {
        if ($this->user !== null) {
            UsersAuthService::deleteCookie();
        }

        header('Location: /');
        return;
    }

    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }

            if ($user instanceof User) {
                $this->view->renderHtml('users/signUpSucc.php');
                return;
            }
        }

        $this->view->renderHtml('users/signUp.php');
    }

    public function edit(int $id): void
    {
        $user = User::getById($id);

        if (!empty($_POST)) {
            try {
                $user->updateFromArray($_POST);
            } catch (InvalidArgumentException $exception) {
                $this->view->renderHtml('users/edit.php', ['error' => $exception->getMessage(), 'user' => $user]);
                return;
            }

            header('Location: /');
            exit();
        }

        $this->view->renderHtml('users/edit.php', ['user' => $user]);
    }
}