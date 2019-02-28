<?php
echo 'account_admin_add';
?>

<form action="?target=product&action=addProduct" method="post" enctype="multipart/form-data" class="form">
    Category<input type="text" name="category" list="category-list" required>
    <datalist id="category-list">
        <option value="Laptop">
        <option value="Phone">
    </datalist>

    Sub-Category<input type="text" name="sub-category" list="sub-category-list" required>
    <datalist id="sub-category-list">
        <option value="Gaming">
        <option value="Ultrabook">
    </datalist>

    Brand<input type="text" name="brand" list="brand-list" required>
    <datalist id="brand-list">
        <option value="Asus">
        <option value="Apple">
    </datalist>
    <br>
    Price <input type="number" name="price" placeholder="price" required>
    Quantity <input type="number" name="quantity" placeholder="quantity" required>
    <br>
    Product Image<input type="file" name="img"><br>
    <input type="submit" name="addProduct" value="Add Product">

</form>

