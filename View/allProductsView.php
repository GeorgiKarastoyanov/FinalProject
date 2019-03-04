<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
    <link rel="stylesheet" href="View/css/styles.css">
</head>
<body onload="pager()">
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
<table>
    <tr>
        <th>Price</th>
        <th>Quantity</th>
        <th>Sub Category</th>
        <th>Category</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Image</th>
        <th>View Product</th>
    </tr>
    <?php foreach ( $params['products'] as $product) {?>
        <tr>
            <td><?php echo $product->getPrice(); ?></td>
            <td><?php echo $product->getQuantity(); ?></td>
            <td><?php echo $product->getSubCategory(); ?></td>
            <td><?php echo $product->getCategory();?></td>
            <td><?php echo $product->getBrand(); ?></td>
            <td><?php echo $product->getModel(); ?></td>
            <td><img src="<?php $product->getImg()?>" width="20px" height="20px"></td>
            <td>
                <a href="?target=product&action=getProduct&productId=<?php echo $product->getId();?>"><button>View details</button></a>
            </td>
            <?php if(isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == 1){ ?>
            <td>
                <button>Edit product</button>
            </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>
<div id="pager" ></div>
</body>
<script type="text/javascript">

    function filter(page = 1) {
        var priceOrder = document.getElementById("priceFilter").value;
        var brand = document.getElementById("brandFilter").value;
        window.location = "?target=product&action=filter&priceOrder=" +priceOrder+"&brand="+brand + "&page=" +page;
    }
    function pager() {
        fetch("index.php?target=product&action=makePages&subCat=" + '<?= $params['subCat']; ?>' + "&brand=" + '<?= $params['selectedBrand']; ?>')
            .then(function (response) {
                return response.json();
            })
            .then(function (myJson) {
                var total = myJson.totalProducts;
                var perPage = myJson.productsPerPage;
                var buttons = Math.ceil(total / perPage);
                var pagera = document.getElementById("pager");
                for (var i = 1; i <= buttons; i++) {
                    var button = document.createElement("button");
                    button.value = i;
                    if(document.getElementById("hiddenPage").value == i){
                        button.style.backgroundColor = 'blue';
                    }
                    button.style.height = '20px';
                    button.style.width = '20px';
                    button.style.margin = '5px';
                    button.innerHTML = i;
                    button.addEventListener('click', function (i) {
                        return function () {
                            filter(i);
                        }
                    }(i));
                    pagera.appendChild(button);
                }

            });
    }


</script>
</html>