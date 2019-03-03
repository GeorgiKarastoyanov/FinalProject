<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
    <link rel="stylesheet" href="View/css/styles.css">
</head>
<body onload="pager()">
<input id="hiddenPage" type="hidden" value="<?php echo $params['page']; ?>">
<select id="priceFilter" onchange="filter()">
    <option value="all" <?php echo $params['selectedOrder'] == "" ? "selected" : "" ?>>Sort by price</option>
    <option value="ascending" <?php echo  $params['selectedOrder'] == "ascending" ? "selected" : ""?>>Ascending</option>
    <option value="descending" <?php echo  $params['selectedOrder'] == "descending" ? "selected" : ""?>>Descending</option>
</select>
<select id="brandFilter" onchange="filter()">
    <option value="all" <?php echo  $params['selectedBrand'] == "" ? "selected" : "" ?>>Sort by brand</option>
    <?php foreach ( $params['brands'] as $brand) {?>
    <option value="<?php echo $brand;  ?>" <?php echo  $params['selectedBrand'] == $brand ? "selected" : "" ?> > <?php echo $brand;  ?></option>
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
        <th>Image</th>
        <th>View Product</th>
    </tr>
    <?php foreach ( $params['products'] as $product) {?>
        <tr>
            <td><?php echo $product->getPrice(); ?></td>
            <td><?php echo $product->getQuantity(); ?></td>
            <td><?php echo $product->getSubCategory(); ?></td>
            <td><?php echo $product->getCategory();?></td>
            <td><?php echo $product->getBrand(); ?></td>
            <td><?php echo $product->getModel(); ?></td>
            <td><img src="<?php $product->getImg()?>" width="20px" height="20px"></td>
            <td>
                <a href="?target=product&action=getProduct&productId=<?php echo $product->getId();?>"><button>View details</button></a>
            </td>
            <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == 1){ ?>
            <td>
                <button>Edit product</button>
            </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>
<div id="pager" ></div>
</body>
<script src="View/js/filters.js"></script>
</html>