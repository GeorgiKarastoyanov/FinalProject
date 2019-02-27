<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
</head>
<body>
<select id="priceFilter" onchange="filter()">
    <option value="all" <?php echo $selectedOrder == "" ? "selected" : "" ?>>Sort by price</option>
    <option value="ascending" <?php echo $selectedOrder == "ascending" ? "selected" : ""?>>Ascending</option>
    <option value="descending" <?php echo $selectedOrder == "descending" ? "selected" : ""?>>Descending</option>
</select>
<select id="brandFilter" onchange="filter()">
    <option value="all" <?php echo $selectedBrand == "" ? "selected" : "" ?>>Sort by brand</option>
    <?php foreach ($brands as $brand) {?>
    <option value="<?php echo $brand;  ?>" <?php echo $selectedBrand == $brand ? "selected" : "" ?> > <?php echo $brand;  ?></option>
    <?php } ?>
</select>
<table>
    <tr>
        <th>Price</th>
        <th>Quantity</th>
        <th>Sub Category</th>
        <th>Category</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Change price</th>
        <th>View Product</th>
    </tr>
    <?php foreach ($products as $product) {?>
        <tr>
            <td><?php echo $product->getPrice(); ?></td>
            <td><?php echo $product->getQuantity(); ?></td>
            <td><?php echo $product->getSubCategory(); ?></td>
            <td><?php echo $product->getCategory();?></td>
            <td><?php echo $product->getBrand(); ?></td>
            <td><?php echo $product->getModel(); ?></td>
            <td>
                <form method="post" action="?target=product&action=changePrice">
                    <input type="hidden" name="productId" value="<?php echo $product->getId(); ?>">
                    <input type="number" name="changePrice" >
                    <input type="submit" name="change" value="Change Price">
                </form>
            </td>
            <td>
                <form method="post" action="?target=product&action=getProduct">
                    <input type="hidden" name="productId" value="<?php echo $product->getId(); ?>">
                    <input type="submit" name="view" value="View">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>
</body>
<script src="View/js/filters.js"></script>
</html>