<?php

namespace controller;

class HomeController extends BaseController
{
    public function index()
    {
        $topProducts = \model\ProductDao::getTopProducts();
        $topBrands = \model\ProductDao::getAllPictureBrands();
        $this->renderView(['topProducts', 'topBrands'],['topProducts' => $topProducts,'topBrands' => $topBrands]);
    }

    public function account()
    {
        $this->renderView(['account', 'accountProfile']);
    }

    public function notFound($message)
    {
        require_once "View/not-found.php";
    }

}