
<link rel="stylesheet" href="View/css/acc-navi.css">
<aside id="acc-aside">
    <nav id="acc-nav">
        <ul>
            <li><a href="?target=home&action=account">Profile</a></li>
            <li><a href="?target=user&action=myOrders">My Orders</a></li>
            <li><a href="?target=user&action=favorites">Favorites</a></li>
            <?php if (isset($_SESSION['user']['isAdmin']) && $_SESSION['user']['isAdmin'] == true) { ?>
                <li><a href='?target=user&action=addProductStep1View'>Add Product</a></li>
                <li><a href='?target=user&action=editProductSearch'>Edit Product</a></li>
                <?php } ?>
            <li><a href="?target=user&action=logout">Log Out</a></li>
        </ul>
    </nav>
</aside>


