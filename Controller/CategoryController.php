<?php
/**
 * Created by PhpStorm.
 * User: Natsi
 * Date: 26.2.2019 г.
 * Time: 16:17
 */

namespace controller;

namespace controller;

use model\SubCategory;
use model\SubCategoryDao;


class CategoryController
{
    public function showAllCategories(){

        if (isset($_POST["allCategories"])){

            $categories = CategoryDao::getAllCategories();


            /** @var Category $category */
        }
        include "view/main.php";
    }

}