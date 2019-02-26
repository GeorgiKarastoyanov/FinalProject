<?php

namespace controller;

class HomeController extends BaseController
{
    public function index() {
      $this->renderView('main');
    }

    public function favorites() {
        $this->renderView('favorites');
    }

    public function account() {
        $this->renderView('account');
    }

    public function cart() {
        $this->renderView('cart');
    }
    public function getAllProducts(){
        $this->renderView('getAllProducts');
    }

    public function notFound($message) {
        require_once "View/not-found.php";
    }
}