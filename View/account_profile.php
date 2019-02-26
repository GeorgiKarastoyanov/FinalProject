<?php

?>

<form action="?target=user&action=edit_profile" method="post" class="form">
    <h1>My Profile</h1>
    Password:<input type="password" name="password" ><br>
    Confirm-Pass:<input type="password" name="confirm-password"><br>
    Email:<input type="email" name="email" placeholder="<?=$_SESSION['user']['email']?>"><br>
    First Name:<input type="text" name="first-name" placeholder="<?=$_SESSION['user']['firstName']?>"><br>
    Last Name:<input type="text" name="last-name" placeholder="<?=$_SESSION['user']['lastName']?>"><br>
    Address:<input type="text" name="address" placeholder="<?=$_SESSION['user']['address']?>"><br>
    <input type="submit" name="edit-profile" value="Save Edit">
    <?= $_SESSION['user']['id'] != 1 ? "<a href=?target=user&action=delete'>Delete Account</a>" : "" ?>
</form>
