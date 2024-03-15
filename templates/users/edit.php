<?php
include __DIR__ . '/../header.php'; ?>
<h1>Изменение учётной записи</h1>
<?php if (!empty($error)): ?>
    <div style="color: red;"><?= $error ?></div>
<?php endif; ?>
<form action="/users/<?= $user->getid() ?>/edit" method="post">
    <label> Логин <input type="text" name="login" value="<?= $_POST['login'] ?? $user->getLogin() ?>"></label><br>
    <label> Почта <input type="text" name="email" value="<?= $_POST['email'] ?? $user->getEmail() ?>"></label><br>
    <label> Телефон <input type="text" name="phone" value="<?= $_POST['phone'] ?? $user->getPhone() ?>"></label><br>
    <label> Новый пароль <input type="password" name="newPassword" value="<?= $_POST['newPassword'] ?? ' ' ?>"></label><br>
    <label> Пароль еще раз <input type="password" name="newPassword2" value="<?= $_POST['newPassword2'] ?? ' ' ?>"></label><br>
    <br>
    <input type="submit" value="Обновить">
</form>
<?php
include __DIR__ . '/../footer.php'; ?>






