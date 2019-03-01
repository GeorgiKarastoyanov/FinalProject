<script src="View/js/addToCart.js"></script>
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
                <td><input type="submit" onclick="addToCart(<?=$favorite['productId'] ?>)" name="<?=$favorite['productId'] ?>" value="Add to cart"></td>
                <td></td>
            </tr>
            <?php } ?>
</table>