<?php


namespace controller;

use model\Product;
use model\ProductDao;
use exception\CustomException;
use exception\InvalidParameterException;
use exception\NotFoundException;

class ProductController extends BaseController{
    public function getAllProducts(){
        include "View/getAllProducts.php";
    }

    public function showAllProducts(){
        $products = ProductDao::getAllProducts();
        include "View/allProductsView.php";
    }

    public function addProductView(){
        include "View/addProducts.php";
    }

    public function addProduct(){
        if(isset($_POST["addProduct"])){
            $id = "";
            $price = $_POST["price"];
            $quantity = $_POST["quantity"];
            $subCat = $_POST["subCat"];
            $category = $_POST["category"];
            $brand = $_POST["brand"];
            $model = $_POST["model"];
            $product = new Product($id,$price,$quantity,$subCat,$category,$model,$brand);
            ProductDao::addProduct($product);
            include"View/added.php";
        }
    }

    public function changePrice(){
        if(isset($_POST["change"])){
            $productId = $_POST["productId"];
            $amount = $_POST["changePrice"];
            ProductDao::changePrice($productId,$amount);
            $products = ProductDao::getAllProducts();
            include "View/allProductsView.php";
        }
    }

    public function getProduct(){
    if(isset($_POST["view"])){
        $productId = $_POST["productId"];
        $product = ProductDao::getProduct($productId);
        include "View/showProduct.php";
    }
    }

    public function orderDetails(){
        if(! isset($_GET['order'])){
            throw new NotFoundException();
        }
        $orderId = $_GET['order'];
        $orderDetails = ProductDao::getOrderDetails($orderId);
        $_SESSION['user']['orderDetails'] = $orderDetails;
        $this->renderView(['account','account_order_details']);
    }

}