<?php


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

    public static function getOrderDetails($orderId){
        $query = "SELECT CONCAT(d.name, ' ', c.name) as productName, a.price, a.quantity FROM ordered_products as a 
                  LEFT JOIN products as b ON b.id = a.productId
                  LEFT JOIN models as c ON c.id = b.modelId
                  LEFT JOIN brands as d ON c.brandId = d.id
                  WHERE orderId = :orderId;";
        $stmt = $GLOBALS['PDO']->prepare($query);
        $stmt->execute(array('orderId' => $orderId));
        $orderDetails = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $orderDetails;
    }
}