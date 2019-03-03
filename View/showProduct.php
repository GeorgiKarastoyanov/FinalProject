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
            <td><?php echo $params['product']->getPrice(); ?></td>
            <td><?php echo $params['product']->getQuantity(); ?></td>
            <td><?php echo $params['product']->getSubCategory(); ?></td>
            <td><?php echo $params['product']->getCategory();?></td>
            <td><?php echo $params['product']->getBrand(); ?></td>
            <td><?php echo $params['product']->getModel(); ?></td>
        </tr>
</table>
<div>
    <?php //TODO show details
    var_dump($params['specifications']) ?>
</div>

</body>
</html>