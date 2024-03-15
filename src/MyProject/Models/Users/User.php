<?php

namespace MyProject\Models\Users;

use MyProject\Exception\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    protected $login;
    protected $email;
    protected $phone;
    protected $authToken;
    protected $passwordHash;
    protected $createdAt;

    public static function signUp(array $userData): User
    {
        if (empty($userData['login'])) {
            throw new InvalidArgumentException('Не передан логин');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $userData['login'])) {
            throw new InvalidArgumentException('Логин может состоять только из символов латинского алфавита и цифр');
        }

        if (empty($userData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (static::findOneByColumn('login', $userData['login']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким логином уже существует');
        }

        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }
        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email некорректен');
        }

        if (static::findOneByColumn('phone', $userData['phone']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким телефоном уже существует');
        }

        if (empty($userData['phone'])) {
            throw new InvalidArgumentException('Не передан номер телефона');
        }

        if (!preg_match('/^(\+)?((\d{2,3}) ?\d|\d)(([ -]?\d)|( ?(\d{2,3}) ?)){5,12}\d$/', $userData['phone'])) {
            throw new InvalidArgumentException('Номер телефона указан в некорректном формате');
        }

        if (empty($userData['password'])) {
            throw new InvalidArgumentException('Не передан пароль');
        }

        if (mb_strlen($userData['password']) < 8) {
            throw new InvalidArgumentException('Пароль должен быть не менее 8 символов');
        }
        if ($userData['password'] !== $userData['password2']) {
            throw new InvalidArgumentException('Пароли не совпадают!');
        }

        $user = new User();
        $user->login = $userData['login'];
        $user->email = $userData['email'];
        $user->phone = $userData['phone'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }

    public static function login(array $loginData): User
    {

        if (empty($loginData['login'])) {
            throw new InvalidArgumentException ('Не передан email или телефон!');
        }

        if (empty($loginData['password'])) {
            throw new InvalidArgumentException('Не передан пароль');
        }

        if (filter_var($loginData['login'], FILTER_VALIDATE_EMAIL)) {
            $user = User::findOneByColumn('email', $loginData['login']);
        } else {
            $user = User::findOneByColumn('phone', $loginData['login']);
        }

        if ($user === null) {
            throw new InvalidArgumentException('Пользователь с таким email или телефоном не найден!');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Неправильный пароль');
        }

        if (!$user->check_captcha($loginData['smart-token'])) {
            throw new InvalidArgumentException('Повторите попытку входа');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    public function updateFromArray(array $fields): User
    {
        if (empty($fields['login'])) {
            throw new InvalidArgumentException('Не передан логин');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $fields['login'])) {
            throw new InvalidArgumentException('Логин может состоять только из символов латинского алфавита и цифр');
        }

        if (empty($fields['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (static::findOneByColumn('login', $fields['login']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким логином уже существует');
        }

        if (static::findOneByColumn('email', $fields['email']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким email уже существует');
        }
        if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email некорректен');
        }

        if (static::findOneByColumn('phone', $fields['phone']) !== null) {
            throw new InvalidArgumentException('Пользователь с таким телефоном уже существует');
        }

        if (empty($fields['phone'])) {
            throw new InvalidArgumentException('Не передан номер телефона');
        }

        if (!preg_match('/^(\+)?((\d{2,3}) ?\d|\d)(([ -]?\d)|( ?(\d{2,3}) ?)){5,12}\d$/', $fields['phone'])) {
            throw new InvalidArgumentException('Номер телефона указан в некорректном формате');
        }

        if (empty($fields['newPassword'])) {
            throw new InvalidArgumentException('Не передан пароль');
        }

        if (mb_strlen($fields['newPassword']) < 8) {
            throw new InvalidArgumentException('Пароль должен быть не менее 8 символов');
        }

        if ($fields['newPassword'] !== $fields['newPassword2']) {
            throw new InvalidArgumentException('Пароли не совпадают!');
        }

        $this->setLogin($fields['login']);
        $this->setEmail($fields['email']);
        $this->setPhone($fields['phone']);
        $this->passwordHash = password_hash($fields['newPassword'], PASSWORD_DEFAULT);

        $this->save();

        return $this;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getAuthToken()
    {
        return $this->authToken;
    }

    private function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }

    public static function getTableName(): string
    {
        return 'users';
    }
}