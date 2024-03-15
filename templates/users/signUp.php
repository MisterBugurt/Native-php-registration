<?php include __DIR__ . '/../header.php'; ?>
<div style="text-align: center;">
    <h1>Регистрация</h1>
    <?php if (!empty($error)): ?>
        <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
    <?php endif; ?>
    <form action="/users/register" method="post">
        <label>Логин <input type="text" name="login" value="<?= $_POST['login'] ?? '' ?>"></label>
        <br><br>
        <label>Email <input type="text" name="email" value="<?= $_POST['email'] ?? '' ?>"></label>
        <br><br>
        <label>Телефон <input type="text" name="phone" value="<?= $_POST['phone'] ?? '' ?>"></label>
        <br><br>
        <label>Введите пароль <input type="password" name="password" value="<?= $_POST['password'] ?? '' ?>"></label>
        <br><br>
        <label>Повторите пароль <input type="password" name="password2" value="<?= $_POST['password2'] ?? '' ?>"></label>
        <br><br>
        <input type="submit" value="Зарегистрироваться">
    </form>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
