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
        <img src="View/images/logo-login.png" id="logo-img" alt="eMAG">
        <h2 id="fav_text">My favourites products</h2>
        <tr>
            <th class="td-favorites">Product Name</th>
            <th class="td-favorites">Price</th>
            <th class="td-favorites">AddCart</th>
            <th class="td-favorites">Remove</th>
        </tr>
        <?php foreach ($params['favorites'] as $favorite) { ?>
            <tr>
                <td class="td-favorites"><?= $favorite['productName'] ?></td>
                <td class="td-favorites"><?= $favorite['price'] ?> $</td>
                <td class="td-favorites">
                    <form method="post" action="?target=product&action=fillCart&field=favourites">
                        <input type="hidden" name="productId" value="<?= $favorite['productId'] ?>">
                        <input type="submit" id="submit" onclick="addToCart('<?= $favorite['productName'] ?>')"
                               value="Add to cart">
                    </form>
                </td>
                <td class="td-favorites"><a href="?target=user&action=removeFavorite&productId=<?= $favorite['productId'] ?>">
                        Remove
                    </a></td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>

