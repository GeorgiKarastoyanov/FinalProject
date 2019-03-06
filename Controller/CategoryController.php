<?php


namespace controller;

use model\SubCategory;
use model\SubCategoryDao;


class CategoryController extends BaseController{
    public function showSubCat(){
        if(isset($_POST["category"])){
            echo json_encode(SubCategoryDao::getSubCategory($_POST["category"]));
        }
    }
}