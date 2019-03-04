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

    include "config.php";
    $GLOBALS["PDO"] = new PDO("mysql:host=127.0.0.1:".DB_PORT.";dbname=emag","root");

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

    if ($e instanceof NotFoundException) {
        $nfController = new HomeController();
        $nfController->notfound($e->getMessage());
    } else if ($e instanceof CustomException) {
        if($e->getField() === 'registerEmail'){
            $errMsg['errMsg'] = $e->getMessage();
            require_once "View/registerEmail.php";
        }
        elseif($e->getField() === 'registerUser'){
            $errMsg['errMsg'] = $e->getMessage();
            require_once "View/registerUser.php";
        }
        elseif($e->getField() === 'loginEmail'){
            $errMsg['errMsg'] = $e->getMessage();
            require_once "View/loginEmail.php";
        }
        elseif($e->getField() === 'loginUser'){
            $errMsg['errMsg'] = $e->getMessage();
            require_once "View/loginUser.php";
        }
    }
    else{
        dd($e);
    }
}
die;


