<?php ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Emag</title>
    <script src="View/js/autoComplete.js"></script>
    <link rel="stylesheet" href="View/css/styles.css">
</head>
<body>
<header>
    <h1><a href="?target=home&action=index">eMag</a></h1>
</header>
<h3>Search bar</h3>
<input id="input-products" onkeyup="loadNames()" type="text" placeholder="Enter product">
<div id="autoComplete"></div>
<br>
<a href="<?= isset($_SESSION['user']) ? '?target=home&action=account' : '?target=user&action=login_email_view'?>">
    <?= isset($_SESSION['user']) ? 'My Account' : 'Log In'?>
</a>
<br>
<?= isset($_SESSION['user']) ? '<a href="?target=user&action=favorites">Favorites</a>' : ''?>
<br>
<a href="?target=user&action=cart">Cart</a>
<br>

