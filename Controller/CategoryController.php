<?php


namespace controller;

use model\SubCategory;
use model\SubCategoryDao;


class CategoryController extends BaseController{
    public function showSubCat(){
        if(isset($_POST["category"])){
            $this->isJson = true;
            return SubCategoryDao::getSubCategory($_POST["category"]);
        }
    }
}