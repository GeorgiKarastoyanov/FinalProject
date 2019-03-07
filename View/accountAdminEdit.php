<?php

$product = $params['product'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit product</title>
    <link rel="stylesheet" href="View/css/edit-product.css">
</head>
<body>
<div class="edit-products">
    <img src="View/images/logo-login.png" id="register-img" alt="eMAG">
    <form action="?target=user&action=editProduct" method="post" class="form">
        <h2 id="edit-product-text"> Edit Product</h2>
        <table class="edit-products-table">
            <tr>
                <th>Price</th>
                <th>Quantity</th>
                <th>Sub Category</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Model</th>
            </tr>
            <tr>
                <td><input type="number" name="price" value="<?= $product->getPrice(); ?>"></td>
                <td><input type="number" name="quantity" value="<?= $product->getQuantity(); ?>"></td>
                <td><?= $product->getSubCategory(); ?></td>
                <td><?= $product->getCategory(); ?></td>
                <td><?= $product->getBrand(); ?></td>
                <td><?= $product->getModel(); ?></td>
            </tr>
        </table>
        <input type="hidden" name="productId" value="<?= $product->getId(); ?>">
        <input type="submit" class="submit-edit" name="edit-product" value="Save Changes">
    </form>
    <div id="err" <?= isset($params['errMsg']) ? "" : "style='display: none'"; ?>><?= isset($params['errMsg']) ? $params['errMsg'] : ""; ?></div>
</div>
</body>
</html>

