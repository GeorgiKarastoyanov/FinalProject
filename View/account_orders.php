<table>
    <tr>
        <th>Order Id</th>
        <th>Date</th>
        <th>Details</th>
    </tr>

<?php if(isset($_SESSION['user']['orders'])){
foreach ( $_SESSION['user']['orders'] as $order) { ?>
    <tr>
        <td><?=$order['id'] ?></td>
        <td><?=$order['date'] ?></td>
        <td><button><a href='?target=product&action=orderDetails&order=<?=$order['id']?>'>Order Details</a></button></td>
    </tr>
   <?php }
} ?>
</table>
