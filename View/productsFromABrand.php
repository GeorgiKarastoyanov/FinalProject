<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<h1 style="text-align: center" ><?=$params['brand']?></h1>
<div class="card-deck" style="margin-top:3.9%; margin-left: 10%; width: 80%; margin-bottom: 4.6% ">
    <?php foreach ( $params['products'] as $product) {?>
        <div class="container, mh-20">
            <h2 style="margin-left: 20px"><?php echo $product->getBrand() . ' ' . $product->getModel(); ?></h2>
            <div id="table-picture-brand" class="card" style="width:250px; height: 270px">
                <img class="card-img-top" src="<?= $product->getImg();?>" alt="Card image" style="width:250px; height: 210px" >
                <div class="card-body" style="text-align: center; background-color: lightgray">
                    <a href="?target=product&action=getProduct&productId=<?php echo $product->getId();?>"
                       class="btn btn-primary , stretched-link" style="width:200px; font-size:25px">View product</a><br>
                    <a style="font-size: 33px"> Price : <?php echo $product->getPrice(); ?> $</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php
$previousLink = '';
$disabled = 'disabled';
if($params['page'] > 1){
    $disabled = '';
    $previousPage = $params['page'] - 1;
    $previousLink = "?target=product&action=showTopBrandProducts&brandName=" . $params['brand'] . "&page=" . $previousPage;
}

$nextLink = '';
$disabledNext = 'disabled';
if($params['page'] < $params['pages']){
    $disabledNext = '';
    $nextPage = $params['page'] + 1;
    $nextLink = "?target=product&action=showTopBrandProducts&brandName=" . $params['brand'] . "&page=" . $nextPage;
}

?>
<nav aria-label="Page navigation example" style="margin-left: 40%" >
    <ul class="pagination justify-content-center" >
        <li class="page-item <?= $disabled ?>" ><a class="page-link" href="<?= $previousLink ?>">Previous</a></li>
        <?php  for($i = 0; $i < $params['pages']; $i++){?>
            <li class="page-item" style="height: 100%; width: 20%" >
                <a class="page-link" href="?target=product&action=showTopBrandProducts&brandName=<?= $params['brand']?>&page=<?= $i + 1; ?>"><?= $i+1; ?></a>
            </li>
        <?php } ?>
        <li class="page-item <?= $disabledNext ?>"><a class="page-link" href="<?= $nextLink ?>">Next</a></li>
    </ul>
</nav>