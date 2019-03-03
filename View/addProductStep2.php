<?php
if(! isset($_SESSION['user']['addProduct'])){
    header("?target=home&action=index");
}
?>
<form action="?target=product&action=addProduct" method="post" enctype="multipart/form-data">
    <h2>Add Product Specifications for <?=$_SESSION['user']['addProduct']['brandName']. " " . $_SESSION['user']['addProduct']['model'] ?></h2>
    <?php foreach ($params['productSpec'] as $spec) {
        echo $spec['name']?> <input type="text" name="spec[<?=$spec['id'] ?>]" required><br>
    <?php } ?>
    Price: <input type="number" name="price" required>
    <br>
    Quantity: <input type="number" name="quantity" required>
    <br>
    Product Image:<input type="file" name="img" >
    <br>
    <input type="submit" name="addProduct" value="AddProduct">
</form>
