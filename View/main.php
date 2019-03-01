<?php
echo 'main';
echo PHP_EOL;
if(!isset($_SESSION['user'])){
    require_once "View/welcome.php";
}

?>


