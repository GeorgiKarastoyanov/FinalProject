<?php

?>
<form action="?target=user&action=buyAction" method="post">
    <h2>Your Cart</h2>
<table>
    <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Remove</th>
    </tr>

    <?php $totalSum = 0;
    /** var Product*/
    foreach ( $params['products'] as $product) {?>
        <tr>
            <td><a href="?target=product&action=getProduct&productId=<?=$product->getId(); ?>">
                <?=$product->getBrand(). ' ' . $product->getModel();?></a></td>
            <td><?=$product->getPrice(); ?></td>
            <td>Quantity(<?=$product->getQuantity(); ?>)<input type="number" name="product[<?=$product->getId(); ?>]" required></td>
            <td><a href="?productId=<?=$product->getId(); ?>"><button>Remove</button></a></td>
        </tr>
        <?php $totalSum += $product->getPrice();
    } ?>

</table>
<h3>Total sum is: <?=$totalSum ?></h3>
    <input type="submit" name="buy" value="Buy">
</form>
