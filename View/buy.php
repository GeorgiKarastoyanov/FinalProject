<?php
$address = $_SESSION['user']['address'];

?>
<link rel="stylesheet" href="View/css/buy.css">
<div id="buy">
    <img src="View/images/logo-login.png" id="register-img" alt="eMAG">
    <h1>Final step</h1>
    <div id="total">
        <h2>You have total of <?=$params['totalProducts'] ?> products and the total price is <?=$params['totalSum'] ?> $</h2>
    </div>
    <form action="?target=product&action=finalBuy" method="post">
    <div id="address">
        <?= $address !== null ? "Your items will arrive soon at $address." :
        "<h2 id='address'>You must set your address to complete the order!</h2><br>
        Adress:<input type='text' name='address'><br>";?>
    </div>
        <input id="complete" type="submit" name="buy" value="Buy">
    </form>
    <div id="err" <?= isset($params['errMsg']) ? "" : "style='display: none'"; ?>><?= isset($params['errMsg']) ? $params['errMsg'] : ""; ?></div>
</div>
