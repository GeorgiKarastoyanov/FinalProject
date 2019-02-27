<?php
/**
 * Created by PhpStorm.
 * User: Natsi
 * Date: 26.2.2019 г.
 * Time: 16:15
 */

namespace model;


class SubCategoryDao
{

    public static function getSubCategory($name)
    {
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT s.id,s.name FROM sub_categories AS s 
                                          JOIN  categories AS c ON (c.id = s.categoryId) WHERE c.name = ?");
        $stmt->execute(array($name));
        $sub_categories = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)){
            $sub_categories[]  = new SubCategory($row->id,$row->name);
        }
        return $sub_categories;
    }
}