<?php

namespace controller;

class HomeController extends BaseController
{
    public function index() {
      $this->renderView(['topProducts','topBrands']);
    }

    public function favorites() {
        $this->renderView(['favorites']);
    }

    public function account() {
        $this->renderView(['account','accountProfile']);
    }

    public function addProduct() {
        $this->renderView(['account','account_admin_add']);
    }

    public function editProduct() {
        $this->renderView(['account','account_admin_edit']);
    }

    public function cart() {
        $this->renderView(['cart']);
    }

    public function getAllProducts(){
        $this->renderView(['getAllProducts']);
    }

    public function notFound($message) {
        require_once "View/not-found.php";
    }

}