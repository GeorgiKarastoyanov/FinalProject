<?php


namespace controller;

use model\Product;
use model\ProductDao;
use exception\CustomException;
use exception\InvalidParameterException;
use exception\NotFoundException;

class ProductController extends BaseController
{
    private $priceOrder = "";
    private $brand = "";

    public function showAllProducts()
    {

        $subCat = $_GET["subCat"];
        $_SESSION["subCat"] = $subCat;
        $products = ProductDao::getAllProducts($subCat);
        $brands = ProductDao::getAllBrands($subCat);
        $selectedOrder = "";
        $selectedBrand = "";
        $this->renderView(['allProductsView'], ['products' => $products, 'brands' => $brands,
            'selectedBrand' => $selectedBrand,
            'selectedOrder' => $selectedOrder]);
    }

    public function addProductView()
    {
        require "View/addProducts.php";
    }

    public function addProduct(){
        if(! isset($_SESSION['user']['addProduct'])){
            throw new CustomException('First Step input not submit');
        }
        if(! isset($_POST['addProduct'])){
            throw new CustomException('Second Step input not submit');
        }
        if(! isset($_POST['price'])){
            throw new CustomException('Price not set');
        }
        if(! isset($_POST['quantity'])){
            throw new CustomException('Price not set');
        }
        if(! isset($_POST['spec'])){
            throw new CustomException('Product spec not set');
        }
        if(empty($_FILES)) {
            throw new CustomException('Img not attached');
        }
        $image_uri = null;
        $tmp_name = $_FILES['img']['tmp_name'];
        if(! is_uploaded_file($tmp_name)) {
            throw new CustomException('Img not uploaded');
        }
        $file_name = time().".jpg";
        if(! move_uploaded_file($tmp_name, "View/images/$file_name")){
            throw new CustomException('Img not moved');
        }
        $image_uri = "View/images/$file_name";



        $specIds = $_POST['spec'];
        $price = $_POST['quantity'];
        $quantity = $_POST['quantity'];
        $brandName = $_SESSION['user']['addProduct']['brandName'];
        $modelName = $_SESSION['user']['addProduct']['model'];
        $subCategoryId = $_SESSION['user']['addProduct']['subCategoryId'];
        $brandId = ProductDao::checkBrandIdExist($brandName,$subCategoryId);
        $productId = null;
        $category = null;
        $modelId = null;
        if($brandId != false){
            $brandName = $brandId['id'];
            $modelId = ProductDao::checkModelIdExist($brandId['id'],$modelName);
        }
        if($modelId != false){
            $modelName = $modelId;
        }
        $addProduct = new Product($productId, $price, $quantity,$subCategoryId, $category, $modelName,$brandName, $image_uri);
        $productId = ProductDao::addProduct($addProduct,$specIds);
        if(!is_numeric($productId)){
            throw new CustomException('Product not added');
        }
        unset($_SESSION['user']['addProduct']);
        header("Location: ?target=product&action=getProduct&productId=$productId");
    }


    public function getProduct()
    {
        if (isset($_GET["productId"]) && !empty($_GET["productId"])) {
            $productId = $_GET["productId"];
            $product = ProductDao::getProduct($productId);
            $specifications = ProductDao::getSpecs($productId);
            $this->renderView(['showProduct'], ['product' => $product, 'specifications' => $specifications]);
        }
        else{
            throw new NotFoundException();
        }

    }

    public function orderDetails()
    {
        if (!isset($_GET['order'])) {
            throw new NotFoundException();
        }
        $orderId = $_GET['order'];
        $orderDetails = ProductDao::getOrderDetails($orderId);
        $this->renderView(['account', 'account_order_details'], ['orderDetails' => $orderDetails]);
    }

    public function filter()
    {
        if (isset($_GET["priceOrder"]) && $_GET["priceOrder"] != "all") {
            $priceOrder = $_GET["priceOrder"];
            $selectedOrder = $priceOrder;
        } else {
            $priceOrder = "";
            $selectedOrder = "";
        }
        if (isset($_GET["brand"]) && $_GET["brand"] != "all") {
            $brand = $_GET["brand"];
            $selectedBrand = $brand;
        } else {
            $brand = "";
            $selectedBrand = "";
        }
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }
        $subCat = $_SESSION["subCat"];

        $products = ProductDao::getAllProducts($subCat, $priceOrder, $brand, $page);
        $brands = ProductDao::getAllBrands($subCat);
        $this->renderView(['allProductsView'], ['products' => $products, 'brands' => $brands, 'page' => $page,
            'priceOrder' => $priceOrder, 'brand' => $brand,
            'selectedBrand' => $selectedBrand,
            'selectedOrder' => $selectedOrder]);

    }


    public function makePages()
    {
        $products = ProductDao::countProducts();
        $arr["totalProducts"] = $products;
        $arr["productsPerPage"] = 2;
        header('Content-Type: application/json');
        echo json_encode($arr);
    }

    public function showAllBrandPictures()
    {
        $brands = ProductDao::getAllPictureBrands();
        $this->renderView(['topBrands'], ['brands' => $brands]);
    }

    public function showAutoLoadNames()
    {
        if(isset($_POST["text"])){
            echo json_encode(ProductDao::getAutoLoadNames());
        }
    }

}