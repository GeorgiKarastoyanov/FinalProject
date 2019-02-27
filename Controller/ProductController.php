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
        //TO DO better validations
//        if(isset($_POST["addProduct"])){
//            $id = "";
//            $price = $_POST["price"];
//            $quantity = $_POST["quantity"];
//            $subCat = $_POST["sub-category"];
//            $category = $_POST["category"];
//            $brand = $_POST["brand"];
//            $model = $_POST["model"];
//            if(empty($_FILES)) {
//                throw new CustomException('File not uploaded');
//            }
//            $tmp_name = $_FILES['img']['tmp_name'];
//            if(!is_uploaded_file($tmp_name)) {
//                throw new CustomException('File not uploaded');
//            }
//            $file_name = $brand.$model.".jpg";
//            if(!move_uploaded_file($tmp_name, "View/product_images/$file_name")) {
//                throw new CustomException('File not uploaded');
//            }
//            $image_uri = "View/product_images/$file_name";
//            $product = new Product($id,$price,$quantity,$subCat,$category,$model,$brand,$image_uri);
//            dd($product);
//            ProductDao::addProduct($product);
//            throw new CustomException('Product Uploaded');
//        }
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
        $this->renderView(['account','account_order_details'],['orderDetails' => $orderDetails]);
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