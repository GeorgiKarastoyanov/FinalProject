
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login User</title>
    <link rel="stylesheet" href="View/css/login-user.css">
</head>
<body>
<img src="View/images/logo-login.png" id="register-img" alt="eMAG">
<div class="reg_mail_container">
    <form action="?target=user&action=loginUser" method="post" class="form">
        <h3 class="reg-text">Please enter your password</h3>
        <input type="password" class="reg_mail" name="password" placeholder="Password" required><br>
        <input type="submit" class="reg_submit-button" name="login" value="Log In"> <br>
        <p class="text-login-reg"><a href="?target=user&action=login_email_view">Go Back</a></p>
        <div id="err" <?= isset($errMsg) ? "" : "style='display: none'"; ?>><?= isset($errMsg) ? $errMsg : ""; ?></div>
    </form>
</div>
</body>
</html>

