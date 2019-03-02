<?php


namespace model;


class ProductDao
{

    public static function getAllProducts($subCat, $priceOrder = "", $brand = "", $page = 1){
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
        
        if($brand != ""){
            $query .= " AND s.name = ?";
            $params[] = $subCat;
        }
        else{
            $query .= " WHERE s.name = ?";
            $params[] = $subCat;
        }
        if($priceOrder === "ascending") {

            $query .= " ORDER BY price";
        }
        if ($priceOrder === "descending") {
            $query .= " ORDER BY price DESC";
        }

        $perPage = 2;
        $offset = ($page - 1) * $perPage;

        $query .= " LIMIT $perPage OFFSET $offset";

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $products = [];
        while ($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $products[] = new Product($row->id, $row->price, $row->quantity, $row->subCat, $row->cat, $row->model, $row->brand);
        }
        return $products;
    }

    public static function countProducts()
    {
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM products");
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $result = $rows[0];
        $count = $result["total"];
        return $count;
    }

    public static function getAllBrands($subCat){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT brands.name as brandName FROM brands JOIN
      sub_categories ON brands.subCategoryId = sub_categories.id WHERE sub_categories.name = :subCat");
        $stmt ->execute(array('subCat' => $subCat));
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $brands = [];
        foreach ($rows as $row){
            $brands[] = $row["brandName"];
            }
        return $brands;
    }

    public static function addProduct(Product $product,$spec){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $pdo->beginTransaction();
        $brandId = $product->getBrand();
        $modelId = $product->getModel();
        try{
            //if $product->getBRand(); is numeric it means that the subCat/brandName pair exist and no need to insert (we have brandId)
            //else we need to insert the brand name with subcategoryId and take new brand ID;
            if(!is_numeric($product->getBrand())){
                $query = "INSERT INTO brands (subCategoryId, name) 
                           VALUES (:subCategoryId, :name);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['subCategoryId' => $product->getSubCategory(), 'name' => $product->getBrand()]);
                $brandId = $pdo->lastInsertId();
            }
            // Next we inset the model because we have brandId
            //if $product->getModel(); is numeric it means that the brandId/modelName pair exist and no need to insert (we have modelId)
            //else we need to insert the modelName with brandId and take the new modelId
            if(!is_numeric($product->getModel())){
                $query = "INSERT INTO models (brandId, name) 
                           VALUES (:brandId, :modelName);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['brandId' => $brandId, 'modelName' => $product->getModel()]);
                $modelId = $pdo->lastInsertId();
            }
            // now we have modelId and we can insert product price and quantity
            $query = "INSERT INTO products (subCategoryId, modelId, price, quantity) 
                           VALUES (:subCategoryId, :modelId, :price, :quantity);";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['subCategoryId' => $product->getSubCategory(), 'modelId' => $modelId,
                            'price' => $product->getPrice(), 'quantity' => $product->getQuantity()]);
            $productId = $pdo->lastInsertId();

            //now we have productId so we can insert product image_uri and product spec values
            //first we insert img
            $query = "INSERT INTO product_images (productId, img_uri) 
                           VALUES (:productId, :img_uri);";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['productId' => $productId, 'img_uri' => $product->getImg()]);
            //lastly we insert product spec values
            //we might have more than 1 spec value to insert so we need to loop to insert all of them
            foreach ($spec as $specId => $value) {
                $query = "INSERT INTO spec_values (productId, specId, value) 
                           VALUES (:productId, :specId, :value);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['productId' => $productId, 'specId' => $specId, 'value' => $value]);
            }

            $pdo->commit();
        }
        catch (\PDOException $e){
            echo "Something went Wrong - " . $e->getMessage();
            $pdo->rollBack();
            return false;
        }
        return $productId;
    }

    public static function changePrice($productId, $amount)
    {
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("UPDATE products SET price = price - ? WHERE id = ?");
        $stmt->execute([$amount, $productId]);
    }

    public static function getProduct($productId)
    {
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT p.id as id, price, quantity, s.name as subCat, c.name as cat,
m.name as model, b.name as brand FROM products as p
JOIN sub_categories as s ON p.subCategoryId = s.id
JOIN categories as c ON s.categoryId = c.id
JOIN models as m ON m.id = p.modelId
JOIN brands as b ON b.id = m.brandId WHERE p.id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$productId]);
        $row = $stmt->fetch(\PDO::FETCH_OBJ);
        $product = new Product($row->id, $row->price, $row->quantity, $row->subCat, $row->cat, $row->model, $row->brand);
        return $product;

    }

    public static function getSpecs($productId)
    {
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT ps.name,sv.value FROM products as p
JOIN spec_values as sv ON sv.productId = p.id
JOIN product_spec as ps ON sv.specID = ps.Id
WHERE p.id = ?");
        $stmt->execute([$productId]);
        $specs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $specs;
    }

    public static function getOrderDetails($orderId)
    {
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

    public static function getTopProducts()
    {
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

    public static function getAllPictureBrands()
    {
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT image_uri FROM brands");
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $brands = [];
        foreach ($rows as $row) {
            $brand = [];
            $brand ["image"] =  $row["image_uri"];
            $brands[] = $brand;
        }
        return $brands;
    }

    public static function checkBrandIdExist($brandName,$subCategoryId){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT id FROM brands WHERE subCategoryId = :subCategoryId AND name = :brandName;";
        $stmt = $pdo->prepare($query);
        $stmt ->execute(array('subCategoryId' => $subCategoryId,'brandName'=> $brandName));
        $brandId = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $brandId;
    }

    public static function checkModelIdExist($brandId,$modelName){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT id FROM models WHERE brandId = :brandId AND name = :modelName;";
        $stmt = $pdo->prepare($query);
        $stmt ->execute(array('brandId' => $brandId,'modelName'=> $modelName));
        $modelId = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $modelId;
    }

}