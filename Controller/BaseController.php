<?php

namespace controller;

abstract class BaseController
{
    public $isJson = false;

    protected function renderView(array $viewNames, array $params = array()){
        require_once "View/header.php";
        foreach ($viewNames as $view){
            require_once "View/" . $view . ".php";
        }
        require_once "View/footer.php";
    }


}