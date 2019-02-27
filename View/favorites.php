
<table>
    <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>AddCart</th>
        <th>Remove</th>
    </tr>

    <?php foreach ( $params['favorites'] as $favorite) { ?>
            <tr>
                <td><?=$favorite['productName'] ?></td>
                <td><?=$favorite['price'] ?></td>
                <td><a href=""></a>Cart</td>
                <td><a href=""></a>Remove</td>
            </tr>
            <?php } ?>
</table>