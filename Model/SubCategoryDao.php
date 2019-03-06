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

    public static function getSubCategory($name = "")
    {
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT s.id,s.name FROM sub_categories AS s
                  JOIN  categories AS c ON (c.id = s.categoryId)";
        $params = [];
        if ($name != "") {
            $query .= " WHERE c.name = :name";
            $params = array('name' => $name);
        }
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $sub_categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $sub_categories;
    }

    public static function getAllDistinctBrands()
    {
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT DISTINCT(name) FROM brands;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $distinctBrands = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $distinctBrands;
    }

    public static function getAllSpecForCategory($subCategoryId){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT id, name FROM product_spec WHERE subCategoryId = :subCategoryId;";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['subCategoryId' => $subCategoryId]);
        $productSpec = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $productSpec;
    }
}