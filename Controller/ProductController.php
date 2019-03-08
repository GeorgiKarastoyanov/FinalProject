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
        $selectedOrder = "";
        $selectedBrand = "";
        $this->renderView(['allProductsView'], [
            'products' => $products,
            'brands' => $brands,
            'selectedBrand' => $selectedBrand,
            'selectedOrder' => $selectedOrder,
            'subCat' => $subCat
        ]);
    }

    public function addProductView()
    {
        require "View/addProducts.php";
    }

    public function addProduct(){
        //todo need a lot of improvements...
        if(! isset($_SESSION['user']['isAdmin']) || $_SESSION['user']['isAdmin'] == false){
            header("Location: ?target=home&action=index");
        }
        if(! isset($_SESSION['user']['addProduct'])){
            throw new CustomException('First Step input not submit');
        }
        if(! isset($_POST['addProduct'])){
            throw new CustomException('Second Step input not submit');
        }
        if(! isset($_POST['price']) || $_POST['price'] < 0){
            throw new CustomException('Invalid price!','addProduct');
        }
        if(! isset($_POST['quantity']) || $_POST['quantity'] < 0){
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

        $products = ProductDao::getAllProducts($subCat, $priceOrder, $brand, $page);
        $brands = ProductDao::getAllBrands($subCat);
        $this->renderView(['allProductsView'], ['products' => $products, 'brands' => $brands, 'page' => $page,
            'priceOrder' => $priceOrder, 'brand' => $brand,
            'selectedBrand' => $selectedBrand,
            'selectedOrder' => $selectedOrder,
            'subCat' => $subCat
        ]);

    }

    public function makePages()
    {
        if(isset($_GET['subCat'])){
            $brand = '';
            $products = ProductDao::countProducts($_GET['subCat'], $brand);
        }else{
            $products = ProductDao::countProducts($_SESSION["subCat"], $_SESSION['brand']);
        }
        $arr["totalProducts"] = $products;
        $arr["productsPerPage"] = 5;
        $this->isJson = true;
        return $arr;
        //header('Content-Type: application/json');
        //echo json_encode($arr);
    }

    public function showAllBrandPictures()
    {
        $brands = ProductDao::getAllPictureBrands();
        $this->renderView(['topBrands'], ['brands' => $brands]);
    }

    public function showAutoLoadNames()
    {
        if(isset($_POST["text"])){
            header("content-type:application/jason");
            $this->isJson = true;
            $text = $_POST["text"];
            return ProductDao::getAutoLoadNames($text);
        }
    }

    public function fillCart(){
        if(isset($_POST['productId'])) {
            $productId = $_POST['productId'];
            $_SESSION['user']['cart'][] = $productId;
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

    public function addToFavourites()
    {
        if (isset($_POST['productId'])) {
            $productId = $_POST['productId'];
            $userId = $_SESSION['user']['id'];
            ProductDao::addToFavourites($userId, $productId);
        }
        header("Location:?target=user&action=favorites");
    }

    public function showTopBrandProducts(){
        if(isset($_GET['brandName']) && !empty($_GET['brandName'])){
            $brand = $_GET['brandName'];
            $products = ProductDao::topBrandsProducts($brand);
            $this->renderView(['productsFromABrand'], ['products' => $products, 'brand' => $brand]);
        }else{
            throw new NotFoundException();
        }
    }

    public function removeFromCart()
    {
        if (isset($_GET['productId'])) {
            $productId = $_GET['productId'];
            unset($_SESSION['user']['cart'][$productId]);
        }
        else{
            header("Location: ?target=product&action=showCart");
        }
    }
}