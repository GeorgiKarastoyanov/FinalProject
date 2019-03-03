
<form action="?target=user&action=loginEmail" method="post" class="form">
    <h1>Log In</h1>
    Email:<input type="email" name="email" placeholder="email" required><br>
    <input type="submit" name="continue" value="Continue">
    <a href="?target=user&action=registerEmailView">Register here</a>
    <div id="err" <?= isset($errMsg['errMsg']) ? "" : "style='display: none'"; ?>><?= isset($errMsg['errMsg']) ? $errMsg['errMsg'] : ""; ?></div>
</form>