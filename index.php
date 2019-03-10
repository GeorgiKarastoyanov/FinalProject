<?php

use exception\NotFoundException;
use exception\CustomException;
use controller\HomeController;

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    $GLOBALS["PDO"] = new PDO("mysql:host=127.0.0.1:".DB_PORT.";dbname=emag","root", "", array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ));

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

    $result = $controller->$methodName();

    if ($controller->isJson) {
        header('Content-Type: application/json');

        echo json_encode($result);
    }
}
catch (Exception $e){

    if ($e instanceof NotFoundException) {
        $nfController = new HomeController();
        $nfController->notfound($e->getMessage());
    } else if ($e instanceof CustomException) {
        $fieldName = $e->getField();
        $errMsg = $e->getMessage();
        $_SESSION['errMsg'] = $errMsg;
        if($fieldName == "registerEmail" || $fieldName == "registerUser" ||
            $fieldName == "loginEmail" || $fieldName == "loginUser"){
            $_SESSION['fieldName'] = $fieldName;
            header("Location: ?target=exception&action=base");
        }
        else{
            header("Location: ?target=exception&action=$fieldName");
        }
    }
    else{
        require_once "View/not-found.php";
    }
}
die;


