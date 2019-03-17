<?php

namespace controller;
use exception\CustomException;

abstract class BaseController
{
    public $isJson = false;

    function testInput($data) {
        //trim() - will strip unnecessary characters (extra space, tab, newline)
        $data = trim($data);
        //stripslashes() - will remove all backlashes
        $data = stripslashes($data);
        //htmlspecialchars - converts special characters to HTML entities
        $data = htmlspecialchars($data);
        return $data;
    }

    function testName($data,$inputBox,$field) {
        if(!ctype_alpha($data)){
            throw new CustomException("$inputBox must contain only alphabetic characters!", $field);
        }
        elseif (strlen($data) < 2) {
            throw new CustomException("$inputBox must be at least two characters long!", $field);
        }
        elseif(strlen($data) > 15){
            throw new CustomException("$inputBox cannot be more than 15 characters long!", $field);
        }
    }

    protected function renderView(array $viewNames, array $params = array()){

        $addParams = [
            'cat' => \model\ProductDao::getAllCategories(),
            'cartProducts' => (isset($_SESSION['user']['cart'])) ? count($_SESSION['user']['cart']) : '0'
        ];

        $params = array_merge($params, $addParams);
        require_once "View/header.php";
        foreach ($viewNames as $view){
            require_once "View/" . $view . ".php";
        }
        require_once "View/footer.php";
    }

}