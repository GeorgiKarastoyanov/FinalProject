<table>
    <tr>
        <th>Order Id</th>
        <th>Date</th>
        <th>Details</th>
    </tr>

<?php foreach ($params['orders'] as $order) { ?>
    <tr>
        <td><?=$order['id'] ?></td>
        <td><?=$order['date'] ?></td>
        <td><button><a href='?target=product&action=orderDetails&order=<?=$order['id']?>'>Order Details</a></button></td>
    </tr>
   <?php } ?>
</table>
<div id="err" <?= isset($params['errMsg']) ? "" : "style='display: none'"; ?>><?= isset($params['errMsg']) ? $params['errMsg'] : ""; ?></div>
