<?php

use exception\NotFoundException;
use exception\InvalidParameterException;
use exception\CustomException;
use controller\HomeController;

try{
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'helpers.php';
    //register autoload
    spl_autoload_register(function ($class){

        $class = str_replace('\\',DIRECTORY_SEPARATOR, $class) . ".php";

        $classPath = __DIR__ . DIRECTORY_SEPARATOR . $class;
        if (! file_exists($classPath)) {
            throw new NotFoundException();
        }
        require_once $classPath;
    });

    $GLOBALS["PDO"] = new PDO("mysql:host=127.0.0.1:3306;dbname=emag","root");
    session_start();

    $controllerName = isset($_GET["target"]) ? $_GET["target"] : "home";
    $methodName = isset($_GET["action"]) ? $_GET["action"] : "index";

    $controllerClassName = '\\Controller\\' . ucfirst($controllerName). "Controller";
    if(! class_exists($controllerClassName)) {
        throw new NotFoundException();
    }

    $controller = new $controllerClassName();
    if (! method_exists($controller, $methodName)) {
        throw new NotFoundException();
    }

    $controller->$methodName();
}
catch (Exception $e){
    dd($e);

    if ($e instanceof NotFoundException) {
        $nfController = new HomeController();
        $nfController->notfound($e->getMessage());
    } else if ($e instanceof InvalidParameterException) {

    } else if ($e instanceof CustomException) {

    }
}
die;


