<?php
$topBrands = $params['topBrands'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="View/css/our_brands.css">
</head>
<body>
<h1>Top Brands</h1>
<div id="table-picture-brand" class="pic">
    <ul id="our_brands-show">
        <?php foreach ($topBrands as $brand) { ?>
            <li><a href="?target=product&action=showTopBrandProducts&brandName=<?php echo $brand["name"]; ?>"><img
                            src="View/<?php echo $brand["image"]; ?>"></a></li>
        <?php } ?>
    </ul>
</div>

</body>
</html>