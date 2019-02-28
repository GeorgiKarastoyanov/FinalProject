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
//    public function showAllCategories(){
//
//        if (isset($_POST["allCategories"])){
//
//            $categories = CategoryDao::getAllCategories();
//
//
//            /** @var Category $category */
//        }
//        include "view/main.php";
//    }

    public static function showSubCat(){
        if(isset($_POST["category"])){
            $test = [];
            $test[] = SubCategoryDao::getSubCategory($_POST["category"]);
            echo json_encode(SubCategoryDao::getSubCategory($_POST["category"]));
        }
        //include "View/allCategoryView.php";
    }
}