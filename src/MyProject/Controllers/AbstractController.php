<?php

namespace MyProject\Controllers;

use MyProject\Models\Users\UsersAuthService;
use MyProject\View\View;

abstract class AbstractController
{
    protected $view;

    protected $user;

    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVar('user', $this->user);
    }
}