<?php

namespace controller;

class HomeController extends BaseController
{
    public static function index() {
        require_once "View/main.php";
    }

    public function notFound($message) {
        require_once "View/not-found.php";
    }
}