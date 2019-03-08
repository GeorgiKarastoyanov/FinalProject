

    <h2>Your Cart</h2>
    <?php  if(! empty($params['products'])) {?>
    <form action="?target=user&action=buyAction" method="post">
<table>
    <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Remove</th>
    </tr>

    <?php $totalSum = 0;
    foreach ( $params['products'] as $product) {?>
        <tr>
            <td><a href="?target=product&action=getProduct&productId=<?=$product->getId(); ?>">
                <?=$product->getBrand(). ' ' . $product->getModel();?></a></td>
            <td><?=$product->getPrice(); ?></td>
            <td>Quantity(<?=$product->getQuantity(); ?>)<input type="number" name="product[<?=$product->getId(); ?>]" value="1" required></td>
            <td><a href="?target=product&action=removeFromCart&productId=<?=$product->getId(); ?>"><button>Remove</button></a></td>
        </tr>
        <?php $totalSum += $product->getPrice();
    } ?>

</table>
        <div id="err" <?= isset($params['errMsg']) ? "" : "style='display: none'"; ?>><?= isset($params['errMsg']) ? $params['errMsg'] : ""; ?></div>
<h3>Total sum is: <?=$totalSum ?></h3>
    <input type="submit" name="buy" value="Buy">
</form>
<?php } else { ?>

<h1>Cart is empty</h1>
<?php } ?>