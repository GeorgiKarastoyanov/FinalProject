<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Orders</title>
    <link rel="stylesheet" href="View/css/my-orders.css">
</head>
<body>
<div id="my-orders-account">
    <img src="View/images/logo-login.png" id="my-acc-logo-img" alt="eMAG">
    <h3>My Orders</h3>
    <table id="table-my-orders">
        <tr>
            <th>Order Id</th>
            <th>Date</th>
            <th>Details</th>
        </tr>

        <?php foreach ($params['orders'] as $order) { ?>
            <tr>
                <td class="td-favorites"><?= $order['id'] ?></td>
                <td class="td-favorites"><?= $order['date'] ?></td>
                <td class="td-favorites">
                    <button><a href='?target=product&action=orderDetails&order=<?= $order['id'] ?>'>Order Details</a>
                    </button>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
