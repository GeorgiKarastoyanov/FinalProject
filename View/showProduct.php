
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<link href="View/css/showProduct.css">


<!DOCTYPE html>
<html>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-4 item-photo">
            <img style="width: 400px;height: 300px" src="<?php echo $params['product']->getImg(); ?>" />
        </div>
        <div class="col-xs-5" style="border:0px solid gray">

            <h1><?php echo $params['product']->getBrand(). ' ' . $params['product']->getModel(); ?></h1>

            <h2 class="title-price"><small>Price</small></h2>
            <h3 style="margin-top:0px;"><?php echo $params['product']->getPrice(); ?> $</h3>

            <div class="section">
                <div>
                    <div class="attr" style="width:25px;background:#5a5a5a;"></div>
                    <div class="attr" style="width:25px;background:white;"></div>
                </div>
            </div>
            <div class="section" style="padding-bottom:20px;">
                <h2 class="title-attr"><small>Quantity (available <?php echo $params['product']->getQuantity(); ?>) </small></h2>
                <div>
                    <input value="1" />
                </div>
            </div>
            <div class="section" style="padding-bottom:20px;">
                <button class="btn btn-success"><span style="margin-right:20px" class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add to cart</button>
                <h6><a href="#"><span class="glyphicon glyphicon-heart-empty" style="cursor:pointer;"></span> Add to favourites</a></h6>
            </div>
        </div>

        <div class="col-xs-9">
            <ul class="menu-items">
                <?php foreach ($params['specifications'] as $specification) { ?>
                    <li class="active"><?php echo $specification["name"] . ' : ' . $specification["value"]; ?> </li>
                <?php } ?>


            </ul>
        </div>
    </div>
</div>
</body>
</html>
