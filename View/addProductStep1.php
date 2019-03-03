
<form action="?target=user&action=addProductStep2View" method="post" class="form">
    Sub-Categories:<select name="sub-categories" id="" required>
    <?php  foreach ($params['allSubCategories'] as $category){ ?>
        "<option value="<?=$category['id'] ?>"><?=$category['name'] ?></option>"
    <?php } ?>
    </select>
    <br>
    Brands:<input type="text" name="brands" list="brands" required/>
    <datalist id="brands">
        <?php  foreach ($params['brands'] as $brand){ ?>
            "<option><?=$brand['name'] ?></option>"
        <?php } ?>
    </datalist>
    <br>
    Model:<input type="text" name="model" required>
    <br>
    <input type="submit" name="addProductStep1" value="Go next">
</form>
