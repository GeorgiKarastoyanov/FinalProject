<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Navigation</title>
    <link rel="stylesheet" href="View/css/acc-navi.css">
</head>
<body>
<div id="acc-navi">
    <aside>
        <nav>
            <table id="table-acc-navi">
                <tr>
                    <td><a href="?target=home&action=account"><label for="" class="label-acc">Profile</label></a></td>
                </tr>
                <tr><td><a href="?target=user&action=myOrders"><label for="" class="label-acc">My Orders</label></a></td>
                </tr>
                <tr>
                    <td><a href="?target=user&action=favorites"><label for="" class="label-acc">Favorites</label></a></td>
                </tr>
                <?php if (isset($_SESSION['user']['isAdmin']) && $_SESSION['user']['isAdmin'] == true) { ?>
                    <tr>
                        <td><a href='?target=user&action=addProductStep1View'><label for="" class="label-acc">Add Product</label></a></td>
                    </tr>
                    <tr>
                        <td><a href='?target=user&action=editProductSearch'><label for="" class="label-acc">Edit Product</label></a></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td><a href="?target=user&action=logout"><label for="" class="label-acc"    >Log Out</label></a></td>
                </tr>
            </table>
        </nav>
    </aside>
</div>
</body>
</html>

