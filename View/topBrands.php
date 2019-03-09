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
<div id="table-picture-brand" class="pic" style="height: 180px">
    <div id="our_brands-show" style="width: 80%; height: 100%; margin: auto; border: 1px solid black" >
        <?php foreach ($topBrands as $brand) { ?>
            <div style="width: 20%; height: 98%; display: inline-block; margin-left: 10%;">
                <a href="?target=product&action=showTopBrandProducts&brandName=<?php echo $brand["name"]; ?>">
                    <img style="width: 100%; height: 98%" src="View/<?php echo $brand["image"]; ?>">
                </a>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>