<?php
$brands = \model\ProductDao::getAllCategories();

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Emag</title>
    <script src="View/js/autoComplete.js"></script>
    <link rel="stylesheet" href="View/css/footer.css">
    <link rel="stylesheet" href="View/css/our_brands.css">
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<header>
    <h1><a href="?target=home&action=index">eMag</a></h1>
</header>
<h3>Search bar</h3>
<input id="input-products" onkeyup="loadNames()" type="text" placeholder="Enter product">
<div id="autoComplete"></div>
<a href="<?= isset($_SESSION['user']) ? '?target=home&action=account' : '?target=user&action=loginEmailView'?>">
    <?= isset($_SESSION['user']) ? 'My Account' : 'Log In'?>
</a>

<?= isset($_SESSION['user']) ? '<a href="?target=user&action=favorites">Favorites</a>' : ''?>

<a href="?target=product&action=showCart">Cart</a>
<br>

<script src="View/js/show_sub_category.js"></script>
<?php foreach ($brands as $brand){ ?>
    <input type="submit" onclick="getSubCategory('<?= $brand['name'];?>')" name='<?= $brand['name'];?>' value='<?= $brand['name'];?>'>
<?php } ?>
<input type="hidden" value="">
<div id="subCategories">
</div>

