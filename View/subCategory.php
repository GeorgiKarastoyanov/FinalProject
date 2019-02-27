<?php

require '../Model/SubCategory.php';

use model\SubCategory;
use model\SubCategoryDao;

function getSubCategory($name){
    /** @var \PDO $pdo */
    $pdo = new PDO("mysql:host=127.0.0.1:3306;dbname=emag","root");
    $stmt = $pdo->prepare("SELECT s.id,s.name FROM sub_categories AS s
                                          JOIN  categories AS c ON (c.id = s.categoryId) WHERE c.name = ?");
    $stmt->execute(array($name));
    $sub_categories = [];
    while($row = $stmt->fetch(\PDO::FETCH_OBJ)){
        $sub_categories[]  = new SubCategory($row->id,$row->name);
    }
    return $sub_categories;
}

$test["subcategory"] = getSubCategory($_POST["category"]);
//$hmm = new SubCategoryDao;
//$hmm = SubCategoryDao::getSubCategory($_POST['category']);
echo json_encode($test);