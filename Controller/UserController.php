<?php

namespace controller;

use exception\CustomException;
use exception\NotFoundException;
use model\ProductDao;
use model\SubCategoryDao;
use Model\UserDao;
use model\UserInfo;

class UserController extends BaseController
{

    public function registerEmail()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new CustomException('Invalid email!', 'registerEmail');
        }

        $email = trim($_POST['email']);

        if (UserDao::existUserByEmail($email)) {
            throw new CustomException('Email already exists!', "registerEmail");
        }

        $_SESSION['register_email'] = $email;

        $this->registerUserView();
    }

    public function registerUser()
    {
        if (!isset($_SESSION['register_email'])) {
            $this->registerEmailView();
        }

        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        if (!isset($_POST['first-name']) || strlen($_POST['first-name']) < 2) {
            throw new CustomException('First name must be at least two characters long!', 'registerUser');
        }

        if (!isset($_POST['last-name']) || strlen($_POST['last-name']) < 2) {
            throw new CustomException('Last name must be at least two characters long!', 'registerUser');
        }

        if (!isset($_POST['password']) || !isset($_POST['confirm-password'])) {
            throw new CustomException('You must enter password!', 'registerUser');
        }
        trim($_POST['password']);
        trim($_POST['confirm-password']);
        if (strlen($_POST['password']) < 6) {
            throw new CustomException('Password must be at least 6 characters long!', 'registerUser');
        }

        if ($_POST['password'] !== $_POST['confirm-password']) {
            throw new CustomException('Passwords do not match!', 'registerUser');
        }
        $email = $_SESSION['register_email'];
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost" => 5]);
        $firstName = $_POST['first-name'];
        $lastName = $_POST['last-name'];
        $user = new UserInfo($email, $password, $firstName, $lastName);
        $userId = UserDao::addUser($user);
        if (!$userId) {
            throw new CustomException('User not added!', 'registerUser');
        }

        $user->setId($userId);
        $_SESSION['user']['id'] = $userId;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['firstName'] = $firstName;
        $_SESSION['user']['lastName'] = $lastName;
        $_SESSION['user']['address'] = $user->getAddress();
        $_SESSION['user']['isAdmin'] = false;

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
        unset($_SESSION['user']);
        header("Location: ?target=home&action=index");
    }

    public function delete()
    {
        if (!isset($_SESSION['user']['id'])) {
            throw new NotFoundException();
        }
        if (!UserDao::delete($_SESSION['user']['id'])) {
            throw new CustomException('Account not deleted!');

        }
        $this->logout();
    }

    public function editProfile()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        if (!isset($_POST['edit-profile'])) {
            throw new NotFoundException();
        }


        //first name
        if (!isset($_POST['first-name'])) {
            throw new CustomException('First name is not set!');
        } else if (strlen($_POST['first-name']) < 2) {
            throw new CustomException('First name must be at least two characters long!');
        } else {
            $firstName = $_POST['first-name'];
        }

        //last name
        if (!isset($_POST['last-name'])) {
            throw new CustomException('Last name is not set!');
        } else if (strlen($_POST['last-name']) < 2) {
            throw new CustomException('Last name must be at least two characters long!');
        } else {
            $lastName = $_POST['last-name'];
        }

        //email
        if (!isset($_POST['email'])) {
            throw new CustomException('Email is not set!');
        }
        $email = trim($_POST['email']);
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new CustomException('Invalid input for email!');
        }

        //password
        if (!isset($_POST['password']) && !isset($_POST['confirm-password']) ||
            ($_POST['password'] == '' && $_POST['confirm-password'] == '')) {
            $password = false;
        } else if (strlen($_POST['password']) < 2) {
            throw new CustomException('Password must be at least 3 characters long!');
        } else if (strlen($_POST['confirm-password']) < 2) {
            throw new CustomException('Confirm-Password must be at least 3 characters long!');
        } else if ($_POST['password'] !== $_POST['confirm-password']) {
            throw new CustomException('Passwords do not match!');
        } else {
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost" => 5]);
        }

        //address
        if (!isset($_POST['address'])) {
            throw new CustomException('Address is not set!');
        } elseif ($_POST['address'] == '') {
            $address = null;
        } elseif (strlen($_POST['address']) < 3) {
            throw new CustomException('Address must be at least 3 characters long!');
        } else {
            $address = $_POST['address'];
        }

        $user = new UserInfo($email, $password, $firstName, $lastName, $address);
        $user->setId($_SESSION['user']['id']);
        if (!UserDao::editProfile($user)) {
            throw new CustomException('Profile not edited!');
        }

        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['firstName'] = $firstName;
        $_SESSION['user']['lastName'] = $lastName;
        $_SESSION['user']['address'] = $address;

        header("Location: ?target=home&action=index");
        
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
        if(! isset($_SESSION['user']) && $_SESSION['user']['isAdmin'] == false){
            header('target=home&action=index');
        }
        $allSubCategories = SubCategoryDao::getSubCategory();
        $distinctBrands = SubCategoryDao::getAllDistinctBrands();
        $this->renderView(['account', 'addProductStep1'], ['allSubCategories' => $allSubCategories, 'brands' => $distinctBrands]);
    }

    public function addProductStep2View()
    {
        if(! isset($_SESSION['user']) && $_SESSION['user']['isAdmin'] == false){
            header('target=home&action=index');
        }
        if (!isset($_POST['addProductStep1'])) {
            throw new CustomException('First Step Not Complete');
        }
        if (!isset($_POST['sub-categories'])) {
            throw new CustomException('Sub-categories not set');
        }
        if (!isset($_POST['brands'])) {
            throw new CustomException('Brands not set');
        }
        if (!isset($_POST['model'])) {
            throw new CustomException('Model not set');
        }

        $subCategoryId = $_POST['sub-categories'];
        $brand = $_POST['brands'];
        $model = $_POST['model'];
        $productSpec = SubCategoryDao::getAllSpecForCategory($subCategoryId);
        $_SESSION['user']['addProduct']['brandName'] = $brand;
        $_SESSION['user']['addProduct']['model'] = $model;
        $_SESSION['user']['addProduct']['subCategoryId'] = $subCategoryId;

        $this->renderView(['account', 'addProductStep2'], ['productSpec' => $productSpec]);


    }

    public function editProductView()
    {
        if(! isset($_SESSION['user']) && $_SESSION['user']['isAdmin'] == false){
            header('target=home&action=index');
        }
        if (!isset($_GET['productId'])) {
            throw new NotFoundException();
        }
        $productId = $_GET['productId'];
        $product = ProductDao::getProduct($productId);
        $this->renderView(['account', 'account_admin_edit'], ['product' => $product]);
    }

    public function editProduct()
    {
        if (!isset($_POST['edit-product'])) {
            throw new CustomException('Form not send!');
        }
        if (!isset($_POST['quantity'])) {
            throw new CustomException('Quantity not set!');
        }
        if (!isset($_POST['price'])) {
            throw new CustomException('Price not set!');
        }
        if (!isset($_POST['productId'])) {
            throw new CustomException('Product ID not set!');
        }
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $productId = $_POST['productId'];
        if (!ProductDao::editProduct($price, $quantity, $productId)) {
            throw new CustomException('Product not edited!');
        }
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
        if (!UserDao::removeFavorite($productId, $userId)) {
            throw new CustomException("Product not removed form favorites");
        }
        header("Location: ?target=user&action=favorites");
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
        //['productId => $quantity]
        $orderedProducts = $_POST['product'];
        $checkIsQtyEnough = ProductDao::checkQtyAvailabilityPerProduct($orderedProducts);
        if(is_array($checkIsQtyEnough)){
            $productId = $checkIsQtyEnough['productId'];
            $quantity = $checkIsQtyEnough['quantity'];
            throw new CustomException("Product with id=$productId have available quantity of $quantity",'cart');
        }
        $userId = $_SESSION['user']['id'];
        //make transaction
        if(! UserDao::buyAction($orderedProducts,$userId)){
            throw new CustomException("Transaction failed!","cart");
        }
        unset($_SESSION['user']['cart']);
        dd("bravo");
        throw new CustomException("Transaction complete your goods will arrive soon :)","cart");
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