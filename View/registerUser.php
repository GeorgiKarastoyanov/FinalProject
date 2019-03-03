
<form action="?target=user&action=registerUser" method="post" class="form">
    <h1>Registration</h1>
    First Name:<input type="text" name="first-name" placeholder="first name"><br>
    Last Name:<input type="text" name="last-name" placeholder="last name"><br>
    Password:<input type="password" name="password" placeholder="password" required><br>
    Confirm-Pass:<input type="password" name="confirm-password" placeholder="confirm-password" required><br>
    <input type="submit" name="register-mail" value="Register">
    <a href="?target=user&action=registerEmailView">Go Back</a>
    <div id="err" <?= isset($errMsg['errMsg']) ? "" : "style='display: none'"; ?>><?= isset($errMsg['errMsg']) ? $errMsg['errMsg'] : ""; ?></div>
</form>