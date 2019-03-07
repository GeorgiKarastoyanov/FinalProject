<?php
$product = $params['product'];
?>

<form action="?target=user&action=editProduct" method="post" class="form">
    <h1>Edit Product</h1>
    <table>
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
            <td><?= $product->getCategory();?></td>
            <td><?= $product->getBrand(); ?></td>
            <td><?= $product->getModel(); ?></td>
        </tr>
    </table>
    <input type="hidden" name="productId" value="<?= $product->getId(); ?>">
    <input type="submit" name="edit-product" value="Save Changes">
</form>
