<?php
$brands = \model\ProductDao::getAllPictureBrands();
?>
<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
<!--    <meta http-equiv="X-UA-Compatible" content="ie=edge">-->
<!--    <title>Document</title>-->
<!--</head>-->
<!--<body>-->
<h1 id="top_brands">Top Brands</h1>
<!--<div id="table-picture-brand" style="">-->
<!--    <ul id="our_brands-show">-->
<!--        --><?php //foreach ($brands as $brand) { ?>
<!--            <li><a href=""><img src="View/--><?php //echo $brand["image"]; ?><!--" alt=""></a></li>-->
<!--        --><?php //} ?>
<!--    </ul>-->
<!--</div>-->
<!---->
<!--</body>-->
<!--</html>-->


<div class="row">
    <div class="col-md-12">

        <div id="mdb-lightbox-ui">

            <div class="mdb-lightbox no-margin">
                <?php foreach ($brands
                as $brand) { ?>
                <figure class="col-md-4">
                    <a href=""
                       data-size="1600x1067">
                        <img alt="picture" src="View/<?php echo $brand["image"]; ?>"
                             class="img-fluid"/>
                    </a>
                </figure>
                <?php } ?>

            </div>
        </div>

    </div>
</div>