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
        require "View/getAllProducts.php";
    }

    public function showAllProducts(){
        $products = ProductDao::getAllProducts();
        $brands = ProductDao::getAllBrands();
        $selectedOrder = "";
        $selectedBrand = "";
        require "View/allProductsView.php";
    }

    public function addProductView(){
        require "View/addProducts.php";
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
            require"View/added.php";
        }
    }

    public function changePrice(){
        if(isset($_POST["change"])){
            $productId = $_POST["productId"];
            $amount = $_POST["changePrice"];
            ProductDao::changePrice($productId,$amount);
            $products = ProductDao::getAllProducts();
            require "View/allProductsView.php";
        }
    }

    public function getProduct(){
    if(isset($_POST["view"])){
        $productId = $_POST["productId"];
        $product = ProductDao::getProduct($productId);
        require "View/showProduct.php";
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
            $priceOrder = $_GET["priceOrder"];
            $selectedOrder = $priceOrder;
        }
        else{
            $priceOrder = "";
            $selectedOrder = "";
        }
        if(isset($_GET["brand"]) && $_GET["brand"] != "all"){
            $brand = $_GET["brand"];
            $selectedBrand = $brand;
        }
        else{
            $brand = "";
            $selectedBrand = "";
        }
        if(isset($_GET["page"])){
            $page = $_GET["page"];
        }
        else{
            $page = 1;
        }
        $products = ProductDao::getAllProducts($priceOrder,$brand,$page);
        $brands = ProductDao::getAllBrands();
        require "View/allProductsView.php";
    }
    public function makePages(){
        $products = ProductDao::countProducts();
        $arr["totalProducts"] = $products;
        $arr["productsPerPage"] = 2;
        header('Content-Type: application/json');
        echo json_encode($arr);
    }
}