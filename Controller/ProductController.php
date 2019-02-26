<?php
/**
 * Created by PhpStorm.
 * User: georg
 * Date: 26.2.2019 г.
 * Time: 14:24
 */

namespace controller;

use model\Product;
use model\ProductDao;

class ProductController{
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
}