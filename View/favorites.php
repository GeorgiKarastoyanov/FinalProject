<script src="View/js/addToCartOrFavourites.js"></script>
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
                <td>
                    <form method="post" action="?target=product&action=fillCart&field=favourites">
                        <input type="hidden" name="productId" value="<?=$favorite['productId']?>">
                        <input type="submit" onclick="addToCart('<?=$favorite['productName'] ?>')" value="Add to cart">
                    </form>
                </td>
                <td><a href="?target=user&action=removeFavorite&productId=<?=$favorite['productId']?>"><button>Remove</button></a></td>
            </tr>
            <?php } ?>
</table>