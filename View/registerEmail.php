<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>registerEmail</title>
    <link rel="stylesheet" href="View/css/registerEmail.css">
</head>
<body>
<img src="View/images/logo-login.png" id="register-img" alt="">
<div class="reg_mail_container">
    <form action="?target=user&action=registerEmail" method="post" class="form">
        <h1 class="reg-text">Welcome!</h1>
        <h3 class="reg-text2">Please enter e-mail address</h3>
        <input type="email" class="reg_mail" name="email" placeholder="email" required><br>
        <input type="submit" class="reg_submit-button" name="register-email" value="Continue"> <br>
        <p class="text-login-reg">You already have an account? <a href="?target=user&action=loginEmailView">Log In</a>
        </p>
        <div id="err" <?= isset($errMsg['errMsg']) ? "" : "style='display: none'"; ?>><?= isset($errMsg['errMsg']) ? $errMsg['errMsg'] : ""; ?></div>
    </form>
</div>
</body>
</html>


