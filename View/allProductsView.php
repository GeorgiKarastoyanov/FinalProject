<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="View/css/our_brands.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="View/css/styles.css">
</head>
<body>
<input id="hiddenPage" type="hidden" value="<?php echo $params['page']; ?>">
<select id="priceFilter" onchange="filter()">
    <option value="all" <?php echo $params['selectedOrder'] == "" ? "selected" : "" ?>>Sort by price</option>
    <option value="ascending" <?php echo  $params['selectedOrder'] == "ascending" ? "selected" : ""?>>Ascending</option>
    <option value="descending" <?php echo  $params['selectedOrder'] == "descending" ? "selected" : ""?>>Descending</option>
</select>
<select id="brandFilter" onchange="filter()">
    <option value="all" <?php echo  $params['selectedBrand'] == "" ? "selected" : "" ?>>Sort by brand</option>
    <?php foreach ( $params['brands'] as $brand) {?>
    <option value="<?php echo $brand;  ?>" <?php echo  $params['selectedBrand'] == $brand ? "selected" : "" ?> > <?php echo $brand;  ?></option>
    <?php } ?>
</select>
<div class="card-deck" style="margin-left: 50px">
    <?php foreach ( $params['products'] as $product) {?>
        <div class="container, mh-20">
            <h6 style="margin-left: 20px"><?php echo $product->getBrand() . ' ' . $product->getModel(); ?></h6>
            <div id="table-picture-brand" class="card" style="width:180px">
                <img class="card-img-top" src="<?= $product->getImg();?>" alt="Card image" style="width:80%">
                <div class="card-body">
                    <a href="?target=product&action=getProduct&productId=<?php echo $product->getId();?>" class="btn btn-primary , stretched-link">View product</a><br>
                    <a> Price : <?php echo $product->getPrice(); ?> $</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<nav aria-label="Page navigation example" style="margin-left: 100px">
    <ul class="pagination justify-content-center">
        <li class="page-item disabled" ><a class="page-link" href="">Previous</a></li>
        <?php  for($i = 0; $i < $params['pages']; $i++){?>
        <li class="page-item" >

            <a class="page-link" href="?target=product&action=filter&priceOrder=all&brand=all&page=<?= $i + 1; ?>"><?= $i+1; ?></a>
            <a class="page-link" href="?target=product&action=filter&priceOrder=<?= $params['selectedOrder']; ?>&page=<?= $i + 1; ?>"><?= $i+1; ?></a>
        </li>
        <?php } ?>
        <li class="page-item disabled"><a class="page-link" href="">Next</a></li>
    </ul>
</nav>
</body>
<script type="text/javascript">

    function filter(page = 1) {
        var priceOrder = document.getElementById("priceFilter").value;
        var brand = document.getElementById("brandFilter").value;
        window.location = "?target=product&action=filter&priceOrder=" +priceOrder+"&brand="+brand + "&page=" +page;
    }
    
</script>
</html>