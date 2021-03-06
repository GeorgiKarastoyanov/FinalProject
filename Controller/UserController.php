<?php

namespace controller;

use exception\CustomException;
use exception\NotFoundException;
use model\ProductDao;
use model\SubCategoryDao;
use model\User;
use Model\UserDao;


class UserController extends BaseController
{

    public function registerEmail()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        //Email validations
        if (isset($_POST['email'])){
            $email=$this->testInput($_POST['email']);
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                throw new CustomException('Invalid email!', 'registerEmail');
            }
        }
        else{
            throw new CustomException('Please enter email!', 'registerEmail');
        }


        if (UserDao::existUserByEmail($email)) {
            throw new CustomException('Email already exists!', "registerEmail");
        }

        $_SESSION['register_email'] = $email;

        $this->registerUserView();
    }

    public function registerUser()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        if (!isset($_SESSION['register_email'])) {
            $this->registerEmailView();
        }

        //First Name validations
        if (isset($_POST['first-name'])){
            $firstName = $this->testInput($_POST['first-name']);
            $_SESSION['registerFirstName'] = $firstName;
            $this->testName($firstName,"First Name",'registerUser');
        }
        else{
            throw new CustomException("Please enter first name!",'registerUser');
        }

        //Last Name validations
        if (isset($_POST['last-name'])){
            $lastName = $this->testInput($_POST['last-name']);
            $_SESSION['registerLastName'] = $lastName;
            $this->testName($lastName,"Last Name",'registerUser');
        }
        else{
            throw new CustomException("Please enter last name!",'registerUser');
        }

        //Password validations
        if(!empty($_POST["password"]) && ($_POST["password"] == $_POST["confirm-password"])) {
            $password =  $this->testInput($_POST["password"]);
            if (strlen($password) < 8) {
                throw new CustomException("Your Password Must Contain At Least 8 Characters!",'registerUser');
            }
            elseif (strlen($password) > 30) {
                throw new CustomException("Your Password Should Not Be More Than 30 Characters !",'registerUser');
            }
            elseif(!preg_match("#[0-9]+#",$password)) {
                throw new CustomException("Your Password Must Contain At Least 1 Number!",'registerUser');
            }
            elseif(!preg_match("#[A-Z]+#",$password)) {
                throw new CustomException("Your Password Must Contain At Least 1 Capital Letter!",'registerUser');
            }
            elseif(!preg_match("#[a-z]+#",$password)) {
                throw new CustomException("Your Password Must Contain At Least 1 Lowercase Letter!",'registerUser');
            }
        }
        elseif(!empty($_POST["password"])) {
            throw new CustomException("Please Check You've Entered Or Confirmed Your Password!",'registerUser');
        } else {
            throw new CustomException("Please enter password!",'registerUser');
        }



        $email = $_SESSION['register_email'];
        $password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 5]);
        $user = new User($email, $password, $firstName, $lastName);
        $userId = UserDao::addUser($user);
        if (!$userId) {
            throw new NotFoundException();
        }

        $user->setId($userId);
        $_SESSION['user']['id'] = $userId;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['firstName'] = $firstName;
        $_SESSION['user']['lastName'] = $lastName;
        $_SESSION['user']['address'] = $user->getAddress();
        $_SESSION['user']['isAdmin'] = false;

        unset($_SESSION['registerFirstName']);
        unset($_SESSION['registerLastName']);
        unset($_SESSION['register_email']);

        header("Location: ?target=home&action=index");

    }

    public function loginEmail()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        if (!isset($_POST['email'])) {
            throw new CustomException('You must enter email!', 'loginEmail');
        }

        if (!UserDao::existUserByEmail($_POST['email'])) {
            throw new CustomException('Invalid email!User does not exist', 'loginEmail');
        }
        $_SESSION['login_email'] = $_POST['email'];
        $this->loginUserView();

    }

    public function loginUser()
    {
        if (!isset($_SESSION['login_email'])) {
            header("Location: ?target=user&action=loginEmail");
        }
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        if (!isset($_POST['password'])) {
            throw new CustomException('Please enter your password!', "loginUser");
        }
        $passwordHash = UserDao::getPasswordByEmail($_SESSION['login_email']);
        if (!password_verify($_POST['password'], $passwordHash)) {
            throw new CustomException('Invalid password!', "loginUser");
        }
        $user = UserDao::getUserByEmail($_SESSION['login_email']);
        $_SESSION['user']['id'] = $user['id'];
        $_SESSION['user']['email'] = $user['email'];
        $_SESSION['user']['firstName'] = $user['firstName'];
        $_SESSION['user']['lastName'] = $user['lastName'];
        $_SESSION['user']['address'] = $user['address'];
        $_SESSION['user']['isAdmin'] = $user['isAdmin'];
        unset($_SESSION['login_email']);
        header("Location: ?target=home&action=index");

    }

    public function logout()
    {
        session_destroy();
        header("Location: ?target=home&action=index");
    }

    public function delete()
    {
        if (!isset($_SESSION['user']['id'])) {
            throw new NotFoundException();
        }
        if (!UserDao::delete($_SESSION['user']['id'])) {
            throw new CustomException('Account not deleted!','accountProfile');
        }
        $this->logout();
    }

    public function editProfile()
    {
        if(! isset($_SESSION['user'])){
            header("Location: ?target=home&action=index");
        }
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        if (!isset($_POST['edit-profile'])) {
            throw new NotFoundException();
        }


        //First Name validations
        if (isset($_POST['first-name'])){
            $firstName = $this->testInput($_POST['first-name']);
            $this->testName($firstName,"First Name",'accountProfile');
        }
        else{
            throw new CustomException("Please enter first name!",'accountProfile');
        }

        //Last Name validations
        if (isset($_POST['last-name'])){
            $lastName = $this->testInput($_POST['last-name']);
            $this->testName($lastName,"Last Name",'accountProfile');
        }
        else{
            throw new CustomException("Please enter last name!",'accountProfile');
        }


        //Email validations
        if (isset($_POST['email'])){
            $email=$this->testInput($_POST['email']);
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                throw new CustomException('Invalid email!', 'accountProfile');
            }
            elseif(UserDao::existUserByEmail($email) && $_POST['email'] !== $_SESSION['user']['email']){
                throw new CustomException('This email already exist!','accountProfile');
            }
        }
        else{
            throw new CustomException('Please enter email!', 'accountProfile');
        }


        //Password validations
        if ((! isset($_POST['password']) && ! isset($_POST['confirm-password'])) ||
            ($_POST['password'] == '' && $_POST['confirm-password'] == '')) {
            $password = false;

        }
        elseif(isset($_POST["password"]) && ($_POST["password"] == $_POST["confirm-password"])) {
            $password =  $this->testInput($_POST["password"]);
            if (strlen($password) < 8) {
                throw new CustomException("Your Password Must Contain At Least 8 Characters!",'accountProfile');
            }
            elseif (strlen($password) > 30) {
                throw new CustomException("Your Password Should Not Be More Than 30 Characters !",'accountProfile');
            }
            elseif(!preg_match("#[0-9]+#",$password)) {
                throw new CustomException("Your Password Must Contain At Least 1 Number!",'accountProfile');
            }
            elseif(!preg_match("#[A-Z]+#",$password)) {
                throw new CustomException("Your Password Must Contain At Least 1 Capital Letter!",'accountProfile');
            }
            elseif(!preg_match("#[a-z]+#",$password)) {
                throw new CustomException("Your Password Must Contain At Least 1 Lowercase Letter!",'accountProfile');
            }
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost" => 5]);
        }
        else{
            throw new CustomException("Passwords Do Not Match!",'accountProfile');
        }



        //address
        if (!isset($_POST['address'])) {
            throw new CustomException('Address is not set!','accountProfile');
        } elseif ($_POST['address'] == '') {
            $address = null;
        } elseif (strlen($_POST['address']) < 6) {
            throw new CustomException('Address must be at least 6 characters long!','accountProfile');
        } else {
            $address = $_POST['address'];
        }

        $user = new User($email, $password, $firstName, $lastName, $address);
        $user->setId($_SESSION['user']['id']);
        if (!UserDao::editProfile($user)) {
            throw new CustomException('Profile not edited!','accountProfile');
        }

        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['firstName'] = $firstName;
        $_SESSION['user']['lastName'] = $lastName;
        $_SESSION['user']['address'] = $address;

        throw new CustomException('Profile updated!','accountProfile');

    }

    public function myOrders()
    {
        if (!isset($_SESSION['user']['id'])) {
            throw new CustomException('You are not logged!');
        }

        $orders = UserDao::getAllOrders($_SESSION['user']['id']);

        $this->renderView(['account', 'accountOrders'], ['orders' => $orders]);


    }

    public function favorites()
    {
        if (!isset($_SESSION['user']['id'])) {
            throw new CustomException('You are not logged!');
        }

        $favorites = UserDao::getFavorites($_SESSION['user']['id']);
        $this->renderView(['account', 'favorites'], ['favorites' => $favorites]);
    }

    public function addProductStep1View()
    {
        if(! isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] == false){
            header('Location: ?target=home&action=index');
        }
        $allSubCategories = SubCategoryDao::getSubCategory();
        $distinctBrands = SubCategoryDao::getAllDistinctBrands();
        $this->renderView(['account', 'addProductStep1'], ['allSubCategories' => $allSubCategories, 'distinctBrands' => $distinctBrands]);
    }

    public function addProductStep2View()
    {
        if(! isset($_SESSION['user']) || $_SESSION['user']['isAdmin'] == false){
            header('Location: ?target=home&action=index');
        }
        if (!isset($_POST['addProductStep1'])) {
            throw new NotFoundException();
        }
        if (!isset($_POST['sub-categories'])) {
            throw new NotFoundException();
        }
        if (!isset($_POST['brand'])) {
            throw new NotFoundException();
        }
        if (!isset($_POST['model'])) {
            throw new NotFoundException();
        }

        $subCategoryId = $_POST['sub-categories'];
        $brandName = $_POST['brand'];
        $modelName = $_POST['model'];
        $brandId = ProductDao::checkBrandIdExist($brandName,$subCategoryId);
        if($brandId != false){
            $brandName = $brandId['id'];
            $modelId = ProductDao::checkModelIdExist($brandId['id'],$modelName);
            if($modelId['id'] != false){
                $productId =ProductDao::getProductIdByModelId($modelId['id']);
                $productId = $productId['id'];
                header("Location: ?target=user&action=editProductView&productId=$productId");
            }
        }
        $productSpec = SubCategoryDao::getAllSpecForCategory($subCategoryId);
        $_SESSION['exceptionParam'] = $productSpec;
        $_SESSION['user']['addProduct']['brandNameView'] = $_POST['brand'];
        $_SESSION['user']['addProduct']['brandName'] = $brandName;
        $_SESSION['user']['addProduct']['model'] = $modelName;
        $_SESSION['user']['addProduct']['subCategoryId'] = $subCategoryId;

        $this->renderView(['account', 'addProductStep2'], ['productSpec' => $productSpec]);


    }

    public function editProductView()
    {
        if(! isset($_SESSION['user']['isAdmin']) || $_SESSION['user']['isAdmin'] == false){
            header('Location: ?target=home&action=index');
        }
        if (!isset($_GET['productId'])) {
            throw new NotFoundException();
        }
        $productId = $_GET['productId'];
        $product = ProductDao::getProduct($productId);
        if($product->getId() == null){
            header("Location: ?target=user&action=editProductSearch");
        }
        $this->renderView(['account', 'accountAdminEdit'], ['product' => $product]);
    }

    public function editProduct()
    {
        if (!isset($_POST['productId'])) {
            throw new NotFoundException();
        }
        //We need this in case of Custom Exception
        $_SESSION['editProductId'] = $_POST['productId'];
        if (!isset($_POST['edit-product'])) {
            throw new CustomException('Form not send!','accountAdminEdit');
        }
        if (!isset($_POST['quantity']) || $_POST['quantity'] < 0 || $_POST['quantity'] > 5000) {
            throw new CustomException('Invalid quantity!','accountAdminEdit');
        }
        if (!isset($_POST['price']) || $_POST['price'] < 0) {
            throw new CustomException('Price must be a positive number!','accountAdminEdit');
        }
        if (!isset($_POST['price']) ||  $_POST['price'] > 20000) {
            throw new CustomException('Max price is 20000$!','accountAdminEdit');
        }


        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $productId = $_POST['productId'];
        if (!ProductDao::editProduct($price, $quantity, $productId)) {
            throw new CustomException('Product not edited!','accountAdminEdit');
        }
        unset($_SESSION['editProductId']);
        header("Location: ?target=product&action=getProduct&productId=$productId");

    }

    public function removeFavorite()
    {
        if (!isset($_GET['productId'])) {
            header("Location: ?target=home&action=index");
        }
        if (!isset($_SESSION['user']['id'])) {
            header("Location: ?target=home&action=index");
        }
        $userId = $_SESSION['user']['id'];
        $productId = $_GET['productId'];

        header("Location: ?target=product&action=getProduct&productId=$productId");
    }

    public function buyAction(){
        if(! isset($_SESSION['user'])){
            header("Location: ?target=home&action=index");
        }
        if(! isset($_POST['buy'])){
            header("Location: ?target=home&action=index");
        }
        if(! isset($_POST['product'])){
            header("Location: ?target=home&action=index");
        }
        foreach ($_POST['product'] as $product){
            if($product['quantity'] < 0){
                throw new CustomException(" Ordered quantity must be a positive number!","cart");
            }
        }
        $orderedProducts = $_POST['product'];
        $checkIsQtyEnough = ProductDao::checkQtyAvailabilityPerProduct($orderedProducts);
        if(is_array($checkIsQtyEnough)){
            $productId = $checkIsQtyEnough['productId'];
            $product = ProductDao::getProduct($productId);
            $productName = $product->getBrand() . ' ' . $product->getModel();
            $quantity = $checkIsQtyEnough['quantity'];
            throw new CustomException("Sorry, we have only $quantity available from $productName",'cart');
        }
        $totalSum = 0;
        $totalProducts = 0;
        foreach ($orderedProducts as $product) {
            $totalSum += $product['price'] * $product['quantity'];
            $totalProducts += $product['quantity'];
        }
        $_SESSION['user']['orderedProducts'] = $orderedProducts;
        $this->renderView(['buy'],['totalSum' => $totalSum,'totalProducts' => $totalProducts]);
    }

    public function loginEmailView(){

        require_once "View/loginEmail.php";
    }

    public function loginUserView()
    {
        require_once "View/loginUser.php";
    }

    public function registerEmailView()
    {
        require_once "View/registerEmail.php";
    }

    public function registerUserView()
    {
        require_once "View/registerUser.php";
    }

    public function editProductSearch()
    {
        $this->renderView(['account', 'adminSearchProductEdit']);
    }
}