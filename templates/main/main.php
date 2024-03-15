<?php include __DIR__ . '/../header.php'; ?>
<?php if (!empty($user)): ?>
    Ваш логин:  <?= $user->getLogin() ?>
    <br>
    Почта <?= $user->getEmail() ?>
    <br>
    Телефон <?= $user->getPhone() ?>
    <br>
    <small><a href="/users/<?= $user->getid() ?>/edit">Изменить данные</a></small>
<?php else: ?>
    <h1>Пожалуйста, зарегистрируйтесь или авторизуйтесь!</h1>
<?php endif ?>
<?php include __DIR__ . '/../footer.php'; ?>
