<?php


namespace controller;
use model\ProductDao;
use model\SubCategoryDao;
use model\UserDao;


class ExceptionController extends BaseController
{
    public function base(){
        if(! isset($_SESSION['errMsg'])){
            header("Location: ?target=home&action=index");
        }
        if(! isset($_SESSION['fieldName'])){
            header("Location: ?target=home&action=index");
        }
        $errMsg = $_SESSION['errMsg'];
        $fieldName = $_SESSION['fieldName'];
        unset($_SESSION['errMsg']);
        unset($_SESSION['fieldName']);
        require_once "View/$fieldName.php";
    }

    public function accountProfile(){
        if(! isset($_SESSION['errMsg'])){
            header("Location: ?target=home&action=index");
        }
        $errMsg = $_SESSION['errMsg'];
        unset($_SESSION['errMsg']);
        $this->renderView(['account','accountProfile'],['errMsg' => $errMsg]);
    }

    public function accountAdminEdit(){
        if(! isset($_SESSION['errMsg'])){
            header("Location: ?target=home&action=index");
        }
        if(! isset($_SESSION['editProductId'])){
            header("Location: ?target=home&action=index");
        }

        $product = ProductDao::getProduct($_SESSION['editProductId']);
        $errMsg = $_SESSION['errMsg'];
        unset($_SESSION['editProductId']);
        unset($_SESSION['errMsg']);
        $this->renderView(['account','accountAdminEdit'],['product' => $product,'errMsg' => $errMsg]);
    }

    public function addProduct(){
        if(! isset($_SESSION['errMsg'])){
            header("Location: ?target=home&action=index");
        }
        $errMsg = $_SESSION['errMsg'];
        unset($_SESSION['errMsg']);
        $allSubCategories = SubCategoryDao::getSubCategory();
        $distinctBrands = SubCategoryDao::getAllDistinctBrands();
        $this->renderView(['account', 'addProductStep1'], ['allSubCategories' => $allSubCategories, 'brands' => $distinctBrands,'errMsg' => $errMsg]);
    }

    public function cart(){
        if(! isset($_SESSION['errMsg'])){
            header("Location: ?target=home&action=index");
        }
        $errMsg = $_SESSION['errMsg'];
        unset($_SESSION['errMsg']);
        $cartProducts = $_SESSION['user']['cart'];
        $idList = implode(',' , $cartProducts);
        $products = ProductDao::showCartProducts($idList);
        $this->renderView(['cart'], ['products' => $products,'errMsg' => $errMsg]);
    }

    public function orders(){
        if(! isset($_SESSION['errMsg'])){
            header("Location: ?target=home&action=index");
        }
        $errMsg = $_SESSION['errMsg'];
        unset($_SESSION['errMsg']);
        $orders = UserDao::getAllOrders($_SESSION['user']['id']);
        $this->renderView(['account', 'accountOrders'], ['orders' => $orders, 'errMsg' => $errMsg]);
    }



}