<?php include __DIR__ . '/../header.php'; ?>
<div style="text-align: center;">
    <h1>Вход</h1>
    <?php if (!empty($error)): ?>
        <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
    <?php endif; ?>
    <form action="/users/login" method="post">
        <label>Email или Номер телефона <input type="text" name="login" value="<?= $_POST['login'] ?? '' ?>"></label>
        <br><br>
        <label>Пароль <input type="password" name="password" value="<?= $_POST['password'] ?? '' ?>"></label>
        <br><br>
        <div id="captcha-container" class="smart-captcha"
             data-sitekey="ysc1_6tuUDufJmnVgyueB3UYwQOoJmtvbqpBd8nV9NyRU4e89cf2c">
            <input type="hidden" name="smart-token" id="smart-token" value="">
        </div>
        <input type="submit" value="Войти">
    </form>
</div>

<script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
<?php include __DIR__ . '/../footer.php'; ?>


