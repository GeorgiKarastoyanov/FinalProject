<?php
$topProducts = \model\ProductDao::getTopProducts();
?>
<table>
    <tr>
        <th>Image</th>
        <th>ProductName</th>
        <th>Details</th>
    </tr>

    <?php foreach ( $topProducts as $favorite) { ?>
            <tr>
                <td><?=$favorite['img_uri'] ?></td>
                <td><?=$favorite['productName'] ?></td>
                <td><a href=""></a>Details</td>
            </tr>
            <?php } ?>
</table>
