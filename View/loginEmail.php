<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login E-mail</title>
    <link rel="stylesheet" href="View/css/registerEmail.css">
</head>
<body>
<a href="?target=home&action=index"><img src="View/images/logo-login.png" id="register-img" alt="eMAG"></a>
<div class="reg_mail_container">
    <form action="?target=user&action=loginEmail" method="post" class="form">
        <h1 class="reg-text">Welcome!</h1>
        <h3 class="reg-text2">Please enter e-mail address to Log In</h3>
        <input type="email" class="reg_mail" name="email" placeholder="email" required><br>
        <input type="submit" class="reg_submit-button" name="continue" value="Continue"> <br>
        <p class="text-login-reg">You are new here? <a href="?target=user&action=registerEmailView">Register</a></p>
        <div id="err" <?= isset($errMsg) ? "" : "style='display: none'"; ?>><?= isset($errMsg) ? $errMsg : ""; ?></div>
    </form>
</div>
</body>
</html>
