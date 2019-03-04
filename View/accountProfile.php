<?php

?>

<form action="?target=user&action=editProfile" method="post" class="form">
    <h1>My Profile</h1>
    Password:<input type="password" name="password" ><br>
    Confirm-Pass:<input type="password" name="confirm-password"><br>
    Email:<input type="email" name="email" value="<?=isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : ""?>"><br>
    First Name:<input type="text" name="first-name" value="<?=isset($_SESSION['user']['firstName']) ? $_SESSION['user']['firstName'] : ""?>"><br>
    Last Name:<input type="text" name="last-name" value="<?=isset($_SESSION['user']['lastName']) ? $_SESSION['user']['lastName'] : ""?>"><br>
    Address:<input type="text" name="address" value="<?=isset($_SESSION['user']['address']) ? $_SESSION['user']['address'] : ""?>"><br>
    <input type="submit" name="edit-profile" value="Save Edit">
    <?= $_SESSION['user']['id'] != 1 ? "<a href=?target=user&action=delete'>Delete Account</a>" : "" ?>
</form>
