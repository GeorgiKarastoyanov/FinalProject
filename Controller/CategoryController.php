<?php
/**
 * Created by PhpStorm.
 * User: Natsi
 * Date: 26.2.2019 г.
 * Time: 16:17
 */

namespace controller;

use model\SubCategory;
use model\SubCategoryDao;


class CategoryController
{

    public static function showSubCat(){
        if(isset($_POST["category"])){
            echo json_encode(SubCategoryDao::getSubCategory($_POST["category"]));
        }
    }
}