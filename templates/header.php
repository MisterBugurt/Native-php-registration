<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тестовая страница </title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Тестовая страница
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <?php if (!empty($user)): ?>
                Привет, <?= $user->getLogin() ?> | <a href="/users/logout">Выйти</a> <br>
            <?php else: ?> <a href="/users/login">Войдите на сайт</a> | <a href="/users/register">
                Зарегистрироваться</a>
            <?php endif ?>
        </td>

    </tr>
    <tr>
        <td>


