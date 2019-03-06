<?php

namespace controller;

class HomeController extends BaseController
{
    public function index()
    {
        $this->renderView(['topProducts', 'topBrands']);
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