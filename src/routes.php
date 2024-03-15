<?php
return [
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~^users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~^users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logout'],
    '~^users/(\d+)/edit$~' => [\MyProject\Controllers\UsersController::class, 'edit'],
];