<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Profile</title>
    <link rel="stylesheet" href="View/css/my-profile.css">
</head>
<body>
<div id="my-profile-account">
    <img src="View/images/logo-login.png" id="account-logo-img" alt="eMAG">
    <form action="?target=user&action=editProfile" method="post" class="form">
        <h3 id="my-prof-text">My Profile</h3>
        <table id="table-my-profile">
            <tr>
                <td><label for="">Password:</label></td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td><label for="">Confirm Password:</label></td>
                <td><input type="password" name="confirm-password"></td>
            </tr>
            <tr>
                <td><label for="">Email:</label></td>
                <td><input type="email" name="email"
                            value="<?= isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : "" ?>"></td>
            </tr>
            <tr>
                <td><label for="">First Name:</label></td>
                <td><input type="text" name="first-name"
                            value="<?= isset($_SESSION['user']['firstName']) ? $_SESSION['user']['firstName'] : "" ?>"></td>
            </tr>
            <tr>
                <td><label for="">Last Name:</label></td>
                <td><input type="text" name="last-name"
                               value="<?= isset($_SESSION['user']['lastName']) ? $_SESSION['user']['lastName'] : "" ?>"></td>
            </tr>
            <tr>
                <td><label for="">Address:</label></td>
                <td><input type="text" name="address"
                           value="<?= isset($_SESSION['user']['address']) ? $_SESSION['user']['address'] : "" ?>"></td>
            </tr>
        </table>
        <input type="submit" id="submit-my-profile" name="edit-profile" value="Save Edit">
        <?= $_SESSION['user']['id'] != 1 ? "<a href=?target=user&action=delete'>Delete Account</a>" : "" ?>

    </form>
</div>
</body>
</html>


