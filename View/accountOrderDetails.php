<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Order-Details</title>
    <link rel="stylesheet" href="View/css/my-order-details.css">
</head>
<body>
<div id="my-order-details-account">
    <img src="View/images/logo-login.png" id="my-acc-logo-img2" alt="eMAG">
    <h3>Details for my orders:</h3>
<table id="table-my-order-details">
    <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Details</th>
    </tr>
    <?php $totalSum = 0;
    foreach ($params['orderDetails'] as $orderDetail) { ?>
        <tr>
            <td><?= $orderDetail['productName'] ?></td>
            <td><?= $orderDetail['singlePrice'] ?>$</td>
            <td><?= $orderDetail['quantity'] ?></td>
            <td><a href="?target=product&action=getProduct&productId=<?= $orderDetail['id'] ?>">
                    <button>See Product</button>
                </a></td>
        </tr>
        <?php $totalSum += $orderDetail['singlePrice'] * $orderDetail['quantity'];
    } ?>
</table>
<h3>Total price is: <?= $totalSum ?>$</h3>
</div>
</body>
</html>