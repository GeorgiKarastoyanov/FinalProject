<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register User</title>
    <link rel="stylesheet" href="View/css/registerUser.css">
</head>
<body>
<img src="View/images/logo-login.png" id="register-img" alt="">
<div id="register_user">
    <form action="?target=user&action=registerUser" method="post" class="form">
        <h1 id="reg_text_user">Registration</h1>
        <label for="" class="reg_user">First Name</label><br>
        <input type="text" class="reg_input" name="first-name" placeholder="First name"><br>
        <label for="" class="reg_user">Last Name </label><br>
        <input type="text" class="reg_input"  name="last-name" placeholder="Last name"><br>
        <label for="" class="reg_user">Password </label><br>
        <input type="password" class="reg_input"  name="password" placeholder="Password" required><br>
        <label for="" class="reg_user">Confirm Password </label><br>
        <input type="password" class="reg_input"  name="confirm-password" placeholder="Confirm password" required><br>
        <input type="submit" class="reg_submit-button" name="register-mail" value="Register"> <br>
        <a href="?target=user&action=registerEmailView">Go Back</a>
        <div id="err" <?= isset($errMsg['errMsg']) ? "" : "style='display: none'"; ?>><?= isset($errMsg['errMsg']) ? $errMsg['errMsg'] : ""; ?></div>
    </form>
</div>
</body>
</html>
