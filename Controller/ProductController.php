<?php


namespace controller;

use model\Product;
use model\ProductDao;
use exception\CustomException;
use exception\NotFoundException;
use model\UserDao;

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
        $count = ProductDao::countProducts($_SESSION["subCat"]);
        $pages = $count/5;
        $selectedOrder = "";
        $selectedBrand = "";
        $this->renderView(['allProductsView'], [
            'products' => $products,
            'brands' => $brands,
            'selectedBrand' => $selectedBrand,
            'selectedOrder' => $selectedOrder,
            'subCat' => $subCat,
            'pages' => $pages
        ]);
    }

    public function addProductView()
    {
        require "View/addProducts.php";
    }

    public function addProduct(){
        if(! isset($_SESSION['user']['isAdmin']) || $_SESSION['user']['isAdmin'] == false){
            header("Location: ?target=home&action=index");
        }
        if(! isset($_SESSION['user']['addProduct'])){
            throw new CustomException('First Step input not submit');
        }
        if(! isset($_POST['addProduct'])){
            throw new CustomException('Second Step input not submit');
        }
        if(! isset($_POST['price']) || $_POST['price'] < 1){
            throw new CustomException('Price must be bigger number than one!','addProduct');
        }
        if(! isset($_POST['price']) || $_POST['price'] > 20000){
            throw new CustomException('Max price is 20000$!','addProduct');
        }
        if(! isset($_POST['quantity']) || $_POST['quantity'] < 0 || $_POST['quantity'] > 5000){
            throw new CustomException('Invalid quantity!','addProduct');
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
        if(! move_uploaded_file($tmp_name, "View/images/products/$file_name")){
            throw new CustomException('Img not moved');
        }
        $image_uri = "View/images/products/$file_name";



        $specIds = $_POST['spec'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $brandName = $_SESSION['user']['addProduct']['brandName'];
        $modelName = $_SESSION['user']['addProduct']['model'];
        $subCategoryId = $_SESSION['user']['addProduct']['subCategoryId'];
        $productId = null;
        $category = null;
        $addProduct = new Product($productId, $price, $quantity,$subCategoryId, $category, $modelName,$brandName, $image_uri);
        $productId = ProductDao::addProduct($addProduct,$specIds);
        if(!is_numeric($productId)){
            throw new CustomException('Product not added');
        }
        unset($_SESSION['user']['addProduct']);
        unset($_SESSION['exceptionParam']);
        header("Location: ?target=product&action=getProduct&productId=$productId");
    }

    public function getProduct()
    {
        if (isset($_GET["productId"]) && !empty($_GET["productId"])
        && ProductDao::checkIfProductExistByProductId($_GET['productId'])) {
            $productId = $_GET["productId"];
            $product = ProductDao::getProduct($productId);
            $specifications = ProductDao::getSpecs($productId);
            $existsInFavourites = false;
            if(isset($_SESSION['user']['id'])){
                $userId = $_SESSION['user']['id'];
                $existsInFavourites = ProductDao::checkIfExist($userId, $productId);
            }
            $this->renderView(['showProduct'],
                ['product' => $product, 'specifications' => $specifications, 'existsInFavourites' => $existsInFavourites]);
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
        $this->renderView(['account', 'accountOrderDetails'], ['orderDetails' => $orderDetails]);
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
        $_SESSION['brand'] = $brand;

        $count = ProductDao::countProducts($_SESSION["subCat"], $_SESSION['brand']);
        $pages = $count/5;

        $products = ProductDao::getAllProducts($subCat, $priceOrder, $brand, $page);
        $brands = ProductDao::getAllBrands($subCat);
        $this->renderView(['allProductsView'], ['products' => $products, 'brands' => $brands, 'page' => $page,
            'priceOrder' => $priceOrder, 'brand' => $brand,
            'selectedBrand' => $selectedBrand,
            'selectedOrder' => $selectedOrder,
            'subCat' => $subCat,
            'pages' => $pages
        ]);

    }

    public function showAllBrandPictures()
    {
        $brands = ProductDao::getAllPictureBrands();
        $this->renderView(['topBrands'], ['brands' => $brands]);
    }

    public function showAutoLoadNames()
    {
        if(isset($_POST["text"])){
            $this->isJson = true;
            $text = $_POST["text"];
            return ProductDao::getAutoLoadNames($text);
        }
    }

    public function fillCart(){
        if(isset($_POST['productId'])) {
            $productId = $_POST['productId'];
            $_SESSION['user']['cart'][$productId] = $productId;
            if(isset($_GET['field']) && $_GET['field'] == 'getProduct' ){
                header("Location:?target=product&action=getProduct&productId=" . $productId);
            }
            elseif(isset($_GET['field']) && $_GET['field'] == 'favourites' ){
                header("Location:?target=user&action=favorites");
            }

        }
    }

    public function showCart(){
        if(isset($_SESSION['user']['cart'])){
            $cartProducts = $_SESSION['user']['cart'];
            $idList = implode(',' , $cartProducts);
            $products = ProductDao::showCartProducts($idList);
            $this->renderView(['cart'], ['products' => $products]);
        }
        $this->renderView(['cart']);
    }

    public function favourites()
    {
        if (isset($_GET['productId'])) {
            $productId = $_GET['productId'];
            $userId = $_SESSION['user']['id'];
            $exists = ProductDao::checkIfExist($userId, $productId);
            if($exists){
                UserDao::removeFavorite($productId, $userId);
            }else{
                ProductDao::addToFavourites($userId, $productId);
            }
        }
        if(isset($_GET['field']) && $_GET['field'] == 'favourites'){
            header("Location:?target=user&action=favorites");
        }else{
            header("Location:?target=product&action=getProduct&productId=$productId");
        }
    }

    public function showTopBrandProducts(){
        if(isset($_GET['brandName']) && !empty($_GET['brandName'])){
            $brand = $_GET['brandName'];
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }else{
                $page = 1;
            }
            $products = ProductDao::topBrandsProducts($brand, $page);
            $count = ProductDao::countProductsByBrand($brand);
            $pages = intval(ceil($count/5));
            $this->renderView(['productsFromABrand'], ['products' => $products, 'brand' => $brand, 'page' => $page, 'pages' => $pages]);
        }else{
            throw new NotFoundException();
        }
    }

    public function removeFromCart()
    {
        if (isset($_GET['productId'])) {
            $productId = $_GET['productId'];
            unset($_SESSION['user']['cart'][$productId]);
            header("Location: ?target=product&action=showCart");
        }
        else{
            header("Location: ?target=product&action=showCart");
        }
    }

    public function finalBuy(){
        if(! isset($_SESSION['user'])){
            header("Location: ?target=home&action=index");
        }
        $userId = $_SESSION['user']['id'];
        if(! isset($_POST['buy'])){
            throw new NotFoundException();
        }
        if($_SESSION['user']['address'] == null){
            if(! isset($_POST['address'])){
                throw new CustomException("You must enter address!","buy");
            }
            if(strlen($_POST['address']) < 3){
                throw new CustomException("The address must be at least 3 characters long!","buy");
            }
            if(! UserDao::addUserAddress($userId,$_POST["address"])) {
                throw new CustomException("Address not inserted!", "buy");
            }
            $_SESSION['user']['address'] = $_POST["address"];
        }
        $orderedProducts = $_SESSION['user']['orderedProducts'];
        if(! UserDao::buyAction($orderedProducts,$userId)){
            throw new CustomException("Transaction failed!","buy");
        }
        unset($_SESSION['user']['cart']);
        unset($_SESSION['user']['orderedProducts']);
        throw new CustomException("Transaction complete your goods will arrive soon :)","orders");
    }
}