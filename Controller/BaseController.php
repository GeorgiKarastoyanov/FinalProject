<?php

namespace controller;

abstract class BaseController
{
    public $isJson = false;

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