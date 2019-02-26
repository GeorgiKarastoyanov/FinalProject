<?php
echo "account nav";
?>
<aside>

        <nav>
            <ul>
                <li><a href="?target=home&action=account">Profile</a></li>
                <li><a href="?target=home&action=account&account=orders">My Orders</a></li>
                <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == 1){ ?>
                <li>Admin Panel
                    <ul>
                        <li><a href='?target=home&action=account&account=admin_add'>Add Product</a></li>
                        <li><a href='?target=home&action=account&account=admin_edit'>Edit Product</a></li>
                    </ul>
                </li> <?php } ?>
                <li><a href="?target=user&action=logout">Log Out</a></li>
            </ul>
        </nav>

</aside>
<?php
if(!isset($_GET['account'])){
    require_once 'account_profile.php';
}
elseif ($_GET['account'] == 'orders'){
    require_once 'account_orders.php';
}
elseif ($_GET['account'] == 'admin_add'){
require_once 'account_admin_add.php';
}
elseif ($_GET['account'] == 'admin_edit'){
    require_once 'account_admin_edit.php';
}
