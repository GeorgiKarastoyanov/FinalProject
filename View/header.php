<?php ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Emag</title>
</head>
<body>
<header>
    <div id="logo"></div>
    <div id="headerTitle">Emag</div>
</header>
<input id="input-products" onkeyup="loadNames()" type="text" placeholder="Enter product">
<div id="autoComplete"></div>
<form>
    <input type="button" value="<?= isset($_SESSION['user']) ? 'My Account' : 'Log In'?>"
           onclick="<?= isset($_SESSION['user']) ? '?target=user&action=account_view' : '?target=user&action=login_email_view'?>" />
</form>
<a href=""></a>
<form action="?target=user&action=favorites">
    <input type="submit" name="favorites" value="Favorites" />
</form>
<form action="?target=user&action=cart">
    <input type="submit" name="cart" value="Cart" />
</form>
