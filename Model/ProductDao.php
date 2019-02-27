<?php


namespace model;


class ProductDao
{
    public static function getAllProducts($priceOrder = "",$brand = "", $page = 1){

        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT p.id as id, price, quantity, s.name as subCat, c.name as cat,
m.name as model, b.name as brand FROM products as p
JOIN sub_categories as s ON p.subCategoryId = s.id
JOIN categories as c ON s.categoryId = c.id
JOIN models as m ON m.id = p.modelId
JOIN brands as b ON b.id = m.brandId";

        $params = [];
        if ($brand != "") {
            $query .= " WHERE b.name = ?";
            $params[] = $brand;
        }

        if($priceOrder === "ascending") {
            $query .= " ORDER BY price";
        }
        if($priceOrder === "descending"){
            $query .= " ORDER BY price DESC";
        }

        $perPage = 2;
        $offset = ($page-1)*$perPage;

        $query .= " LIMIT $perPage OFFSET $offset";

        $stmt = $pdo->prepare($query);
        $stmt ->execute($params);
        $products = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)){
            $products[] = new Product($row->id,$row->price, $row->quantity, $row->subCat,$row->cat ,$row->model, $row->brand);
        }
        return $products;
    }

    public static function countProducts(){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM products");
        $stmt ->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = $rows[0];
        $count = $result["total"];
        return $count;
    }
    public static function getAllBrands(){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT name FROM brands");
        $stmt ->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $brands = [];
        foreach ($rows as $row){
            $brands[] = $row["name"];
        }
        return $brands;
    }

    public static function addProduct(Product $product){
//        /** @var \PDO $pdo */
//        $pdo = $GLOBALS["PDO"];
//        $pdo->beginTransaction();
//        try {
//            if($product)
//            $query = "INSERT INTO categories (name) VALUES (:category);";
//            $stmt = $pdo->prepare($query);
//            $stmt->execute(array("category" => $product->getCategory()));
//
//
//            $pdo->commit();
//        }
//        catch (\PDOException $e){
//            echo "error - " . $e->getMessage();
//            $pdo->rollBack();
//            return false;
//        }
        return true;
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

    public static function getTopProducts(){
        $query = "SELECT CONCAT(c.name, ' ', b.name) as productName, SUM(a.quantity) as totalSells, e.img_uri FROM ordered_products as a
                  LEFT JOIN products as d ON d.id = a.productId
                  LEFT JOIN models as b ON b.id = d.modelId
                  LEFT JOIN brands as c ON c.id = b.brandid
                  LEFT JOIN products_images as e ON b.id = e.productId
                  GROUP BY a.productId ORDER BY totalSells DESC LIMIT 5;";
        $stmt = $GLOBALS['PDO']->prepare($query);
        $stmt->execute();
        $topProducts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $topProducts;
    }
}