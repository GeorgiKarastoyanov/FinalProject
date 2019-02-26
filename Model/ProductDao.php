<?php
/**
 * Created by PhpStorm.
 * User: georg
 * Date: 26.2.2019 г.
 * Time: 14:22
 */

namespace model;


class ProductDao
{
    public static function getAllProducts(){

        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT p.id as id, price, quantity, s.name as subCat, c.name as cat,
m.name as model, b.name as brand FROM products as p
JOIN sub_categories as s ON p.subCategoryId = s.id
JOIN categories as c ON s.categoryId = c.id
JOIN models as m ON m.id = p.modelId
JOIN brands as b ON b.id = m.brandId";

        $stmt = $pdo->prepare($query);
        $stmt ->execute();
        $products = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)){
            $products[] = new Product($row->id,$row->price, $row->quantity, $row->subCat,$row->cat ,$row->model, $row->brand);
        }
        return $products;
    }

    public static function addProduct(Product $product){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("INSERT INTO products (subCategoryId, modelId, price, quantity) 
        VALUES ((SELECT id FROM sub_categories WHERE name = ?), 
        (SELECT id FROM models WHERE name = ?), ?, ?)");
        $stmt ->execute([$product->getSubCategory(),$product->getModel(),$product->getPrice(),$product->getQuantity()]);
    }

    public static function changePrice($productId, $amount){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("UPDATE products SET price = price - ? WHERE id = ?");
        $stmt -> execute([$amount,$productId]);
    }

    public static function getProduct($productId){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT p.id as id, price, quantity, s.name as subCat, c.name as cat,
m.name as model, b.name as brand FROM products as p
JOIN sub_categories as s ON p.subCategoryId = s.id
JOIN categories as c ON s.categoryId = c.id
JOIN models as m ON m.id = p.modelId
JOIN brands as b ON b.id = m.brandId WHERE p.id = ?";
        $stmt = $pdo->prepare($query);
        $stmt ->execute([$productId]);
        $row = $stmt->fetch(\PDO::FETCH_OBJ);
        $product = new Product($row->id,$row->price, $row->quantity, $row->subCat,$row->cat ,$row->model, $row->brand);
        return $product;

    }
}