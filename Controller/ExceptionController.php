<?php


namespace controller;
use model\ProductDao;


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

}