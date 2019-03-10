<?php
$address = $_SESSION['user']['address'];

?>
<link rel="stylesheet" href="View/css/buy.css">
<div id="buy">
    <h1>Final step</h1>
    <div>
        <h2>You have total of <?=$params['totalProducts'] ?> products and the total price is <?=$params['totalSum'] ?></h2>
    </div>
    <form action="?target=product&action=finalBuy" method="post">
    <div>
        <?= $address !== null ? "Your address is $address." :
        "<h2>You must set your address to complete the order!</h2><br>
        Adress:<input type='text' name='address'><br>";?>
    </div>
        <input id="complete" type="submit" name="buy" value="Buy">
    </form>
    <div id="err" <?= isset($params['errMsg']) ? "" : "style='display: none'"; ?>><?= isset($params['errMsg']) ? $params['errMsg'] : ""; ?></div>
</div>
