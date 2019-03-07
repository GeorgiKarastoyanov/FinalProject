<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Favorites</title>
    <link rel="stylesheet" href="View/css/favorites.css">
    <script src="View/js/addToCartOrFavourites.js"></script>
</head>
<body>
<div id="favorites">
    <table id="favorite-product">
        <h2 id="fav_text">My favourites products</h2>
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>AddCart</th>
            <th>Remove</th>
        </tr>
        <?php foreach ($params['favorites'] as $favorite) { ?>
            <tr>
                <td><?= $favorite['productName'] ?></td>
                <td><?= $favorite['price'] ?></td>
                <td>
                    <form method="post" action="?target=product&action=fillCart&field=favourites">
                        <input type="hidden" name="productId" value="<?= $favorite['productId'] ?>">
                        <input type="submit" id="submit" onclick="addToCart('<?= $favorite['productName'] ?>')"
                               value="Add to cart">
                    </form>
                </td>
                <td><a href="?target=user&action=removeFavorite&productId=<?= $favorite['productId'] ?>">
                        <button id="fav_remove">Remove</button>
                    </a></td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>

