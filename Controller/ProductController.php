<?php


namespace controller;

use model\Product;
use model\ProductDao;
use exception\CustomException;
use exception\InvalidParameterException;
use exception\NotFoundException;

class ProductController extends BaseController{
    private $priceOrder = "";
    private $brand = "";

    public function getAllProducts(){
        include "View/getAllProducts.php";
    }

    public function showAllProducts(){
        $products = ProductDao::getAllProducts($this->priceOrder,$this->brand);
        $brands = ProductDao::getAllBrands();
        $selectedOrder = "";
        $selectedBrand = "";
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
            $products = ProductDao::getAllProducts($this->priceOrder,$this->brand);
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

    public function filter(){
        if(isset($_GET["priceOrder"]) && $_GET["priceOrder"] != "all"){
            $this->priceOrder = $_GET["priceOrder"];
            $selectedOrder = $this->priceOrder;
        }
        else{
            $selectedOrder = "";
        }
        if(isset($_GET["brand"]) && $_GET["brand"] != "all"){
            $this->brand = $_GET["brand"];
            $selectedBrand = $this->brand;
        }
        else{
            $selectedBrand = "";
        }
        $products = ProductDao::getAllProducts($this->priceOrder,$this->brand);
        $brands = ProductDao::getAllBrands();
        include "View/allProductsView.php";
    }
}