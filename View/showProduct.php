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
            <td><?php echo $product->getPrice(); ?></td>
            <td><?php echo $product->getQuantity(); ?></td>
            <td><?php echo $product->getSubCategory(); ?></td>
            <td><?php echo $product->getCategory();?></td>
            <td><?php echo $product->getBrand(); ?></td>
            <td><?php echo $product->getModel(); ?></td>
        </tr>
</table>
</body>
</html>