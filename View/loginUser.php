
<form action="?target=user&action=loginUser" method="post" class="form">
    <h1>Log In</h1>
    Password:<input type="password" name="password" placeholder="password" required><br>
    <input type="submit" name="login" value="Log In">
    <a href="?target=user&action=loginEmailView">Go Back</a>
    <div id="err" <?= isset($errMsg['errMsg']) ? "" : "style='display: none'"; ?>><?= isset($errMsg['errMsg']) ? $errMsg['errMsg'] : ""; ?></div>
</form>