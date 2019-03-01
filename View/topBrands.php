<?php
$brands = \model\ProductDao::getAllPictureBrands();
?>
<div id="table-picture-brand">

<h3>Our Brands</h3>

<?php foreach ($brands as $brand){ ?>

    <a href=""><img width="100px" src="View/<?php echo $brand["image"];?>" alt=""></a>
<?php } ?>

</div>

