<?php
$brands = \model\ProductDao::getAllCategories();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Emag</title>
    <script src="View/js/autoComplete.js"></script>
    <link rel="shortcut icon" sizes="any" type="image/png" href="https://s12emagst.akamaized.net/assets/bg/css/icons/favicon.ico?v=1a">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="View/css/header.css">
</head>
<body>
<nav id="NAV_1">
    <a href="?target=home&action=index" id="A_2"><img src="https://s12emagst.akamaized.net/layout/bg/images/logo//12/17641.png" width="138px" height="38px" alt="eMAG"></a>
    <div id="DIV_5">
        <input  style="width: 504px; margin-left: 100px; height: 41px;"
                id="input-products" onkeyup="loadNames()" type="text" placeholder="Enter product">

        <ul id="UL_6">
            <li>
                <div id="welcome"> <?= isset($_SESSION['user']['id']) ? "Welcome, ".$_SESSION['user']['firstName'] : ''?></div>
            </li>
            <li id="LI_7">
                <a href="<?= isset($_SESSION['user']['id']) ? '?target=home&action=account' : '?target=user&action=loginEmailView'?>" id="A_8">
                    <?= isset($_SESSION['user']['id']) ? 'Account' : 'LogIn'?><span id="SPAN_9"></span></a>
            </li>
            <li id="LI_10" style="margin-left: 35px">
                <a href="<?= isset($_SESSION['user']['id']) ? '?target=product&action=showCart' : '?target=user&action=loginEmailView'?>" id="A_11">Cart</a>
            </li>
            <li id="LI_12">
                <a href="<?= isset($_SESSION['user']['id']) ? '?target=user&action=favorites' : '?target=user&action=loginEmailView'?>" id="A_13">Favourites</a>
            </li>
        </ul>
    </div>
</nav>
<div id="autoComplete"></div>
<div id="categoriesNav">
    <?php foreach ($brands as $brand){ ?>
        <input id="categories" type="submit" onclick="getSubCategory('<?= $brand['name'];?>')" name='<?= $brand['name'];?>' value='<?= $brand['name'];?>'>
    <?php } ?>
</div>
<div id="subCategories" >
</div>

<div id="autoComplete"></div>

<?php if(!isset($_SESSION['user']['id'])){?>
<div id="notLogged">
    <div style="float: left">
        Welcome to eMag!<br>
        Please login to use all features of the website.
    </div>
    <a href="?target=user&action=loginEmailView" class="button"> Log In</a>
    <a class="button button2" href="?target=user&action=registerEmailView">Register</a>
</div>
<?php } ?>
</body>
<script src="View/js/show_sub_category.js"></script>

