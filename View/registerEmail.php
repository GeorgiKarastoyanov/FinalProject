
<form action="?target=user&action=registerEmail" method="post" class="form">
    <h1>Registration</h1>
    Email:<input type="email" name="email" placeholder="email" required><br>
    <input type="submit" name="register-email" value="Register">
    <a href="?target=user&action=loginEmailView">Log In</a>
    <div id="err" <?= isset($errMsg['errMsg']) ? "" : "style='display: none'"; ?>><?= isset($errMsg['errMsg']) ? $errMsg['errMsg'] : ""; ?></div>
</form>

