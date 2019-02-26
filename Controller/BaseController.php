<?php

namespace controller;

abstract class BaseController
{
    protected function renderView($viewName){
        require_once "View/header.php";
        require_once "View/" . $viewName . ".php";
        require_once "View/footer.php";
    }


}