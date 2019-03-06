<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<h1><?=$params['brand']?></h1>
<div class="card-deck" style="margin-left: 50px">
    <?php foreach ( $params['products'] as $product) { ?>
        <div class="container, mh-20">
            <h6 style="margin-left: 20px"><?= $product->getBrand(). '' . $product->getModel(); ?></h6>
            <div class="card" style="width:180px">
                <img class="card-img-top" src="<?=$product->getImg() ?>" style="width:80%">
                <div class="card-body">
                    <a href="?target=product&action=getProduct&productId=<?php echo $product->getId();?>" class="btn btn-primary , stretched-link">View product</a><br>
                    <a> Price : <?=$product->getPrice() ?> $</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>