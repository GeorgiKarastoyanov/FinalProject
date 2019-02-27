<table>
    <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
    </tr>

    <?php $totalSum = 0;
        foreach ( $params['orderDetails'] as $orderDetail) { ?>
            <tr>
                <td><?=$orderDetail['productName'] ?></td>
                <td><?=$orderDetail['price'] ?></td>
                <td><?=$orderDetail['quantity'] ?></td>
            </tr>
            <?php $totalSum += $orderDetail['price'];
    } ?>
</table>
<h3>Total sum is: <?=$totalSum ?></h3>