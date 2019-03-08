
<div style="height: 70vh">
    <h2>Your Cart</h2>
    <?php  if(! empty($params['products'])) {?>
        <form action="?target=user&action=buyAction" method="post">
            <div class="card-deck" style="margin-left: 50px">
                <?php $totalSum = 0;
                foreach ( $params['products'] as $product) {?>
                    <div class="container, mh-20" style="margin-left: 50px; display: inline-block" >
                        <h4 style="margin-left: 20px"><?=$product->getBrand(). ' ' . $product->getModel();?></h4>
                        <div id="table-picture-brand" class="card" style="width:180px">
                            <img class="card-img-top" src="<?= $product->getImg(); ?>" alt="Card image" style="width:80%">
                            <div class="card-body">
                            <a href="?target=product&action=getProduct&productId=<?=$product->getId(); ?>" class="btn btn-primary , stretched-link">View product</a><br>
                                Price :<?= $product->getPrice(); ?> $<br>
                                Quantity(<?=$product->getQuantity(); ?>)<input type="number" name="product[<?=$product->getId(); ?>]" value="1" required>
                                <a href="?target=product&action=removeFromCart&productId=<?=$product->getId(); ?>"
                                   class="btn btn-primary , streched-link" style="color: white; background-color: grey">Remove from cart</a>
                            </div>
                        </div>
                    </div>
                    <?php $totalSum += $product->getPrice();
                 } ?>
            </div>
            <div >
                <input   type="submit" name="buy" value="Buy">
                <h3 >Total sum is: <?=$totalSum ?></h3>
            </div>
        </form>
    <?php } else { ?>
        <h1>Cart is empty</h1>
    <?php } ?>
</div>
