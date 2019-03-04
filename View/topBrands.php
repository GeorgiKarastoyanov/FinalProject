<?php
$brands = \model\ProductDao::getAllPictureBrands();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h3>Our Brands</h3>
<div id="table-picture-brand">
    <ul id="our_brands-show">
        <?php foreach ($brands as $brand){ ?>
        <li><a href=""><img src="View/<?php echo $brand["image"];?>" alt=""></a></li>
        <?php } ?>
    </ul>
</div>
</body>
</html>



