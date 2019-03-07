<?php
/**
 * Created by PhpStorm.
 * User: STRYGWYR
 * Date: 3/4/2019
 * Time: 7:25 PM
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search</title>
    <script src="View/js/autoComplete.js"></script>
    <link rel="stylesheet" href="View/css/edit-product.css">
</head>
<body>
<div class="search-edit">
    <img src="View/images/logo-login.png" id="logo" alt="">
    <h3 class="search-box">Search product</h3>
    <input id="input-products2" class="search-box-field" onkeyup="loadProducts()" type="text"
           placeholder="Enter product">
    <div id="autoComplete2"></div>
</div>
</body>
</html>


