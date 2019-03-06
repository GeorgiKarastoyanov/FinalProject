<?php


namespace model;


class ProductDao{

    public static function getAllProducts($subCat, $priceOrder = "", $brand = "", $page = 1){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT p.id, p.price, p.quantity, s.name as subCat, c.name as cat, m.name as model, b.name as brand, pi.img_uri as img FROM products as p
                  LEFT JOIN sub_categories as s ON p.subCategoryId = s.id
                  LEFT JOIN categories as c ON s.categoryId = c.id
                  LEFT JOIN models as m ON m.id = p.modelId
                  LEFT JOIN brands as b ON b.id = m.brandId
                  LEFT JOIN products_images as pi ON pi.productId = p.id";

        $params = [];
        if ($brand != "") {
            $query .= " WHERE b.name = :subCat";
            $params = array('subCat' => $subCat);
        }

        if ($brand != "") {
            $query .= " AND s.name = :brand";
            $params = array('subCat' => $subCat, 'brand' => $brand);
        } else {
            $query .= " WHERE s.name = :subCat";
            $params = array('subCat' => $subCat);
        }
        if ($priceOrder === "ascending") {

            $query .= " ORDER BY price";
        }
        if ($priceOrder === "descending") {
            $query .= " ORDER BY price DESC";
        }

        $perPage = 5;
        $offset = ($page - 1) * $perPage;

        $query .= " LIMIT $perPage OFFSET $offset";

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $products = [];

        while ($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $products[] = new Product($row->id, $row->price, $row->quantity, $row->subCat, $row->cat, $row->model, $row->brand, $row->img);
        }
        return $products;
    }

    public static function countProducts($subCat = "", $brand = ""){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT COUNT(*) as total FROM products as a
                  LEFT JOIN sub_categories as b ON a.subCategoryId = b.id
                  LEFT JOIN brands as c ON c.id = a.subCategoryId";
        if (!empty($subCat)) {
            $query .= " WHERE b.name = :subCat";
            $params = array('subCat' => $subCat);
            if (!empty($brand)) {
                $query .= " AND c.name = :brand";
                $params = array('subCat' => $subCat, 'brand' => $brand);
            }

        }
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row["total"];
    }

    public static function getAllBrands($subCat){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT brands.name as brandName FROM brands JOIN
        sub_categories ON brands.subCategoryId = sub_categories.id WHERE sub_categories.name = :subCat");
        $stmt->execute(array('subCat' => $subCat));
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $brands = [];
        foreach ($rows as $row) {
            $brands[] = $row["brandName"];
        }
        return $brands;
    }

    public static function addProduct(Product $product, $spec){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $pdo->beginTransaction();
        $brandId = $product->getBrand();
        $modelId = $product->getModel();
        try {
            //if $product->getBRand(); is numeric it means that the subCat/brandName pair exist and no need to insert (we have brandId)
            //else we need to insert the brand name with subcategoryId and take new brand ID;
            if (!is_numeric($product->getBrand())) {
                $query = "INSERT INTO brands (subCategoryId, name) 
                           VALUES (:subCategoryId, :name);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['subCategoryId' => $product->getSubCategory(), 'name' => $product->getBrand()]);
                $brandId = $pdo->lastInsertId();
            }
            // Next we inset the model because we have brandId
            //if $product->getModel(); is numeric it means that the brandId/modelName pair exist and no need to insert (we have modelId)
            //else we need to insert the modelName with brandId and take the new modelId
            if (!is_numeric($product->getModel())) {
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
        } catch (\PDOException $e) {
            echo "Something went Wrong - " . $e->getMessage();
            $pdo->rollBack();
            return false;
        }
        return $productId;
    }

//    public static function changePrice($productId, $amount)
//    {
//        /** @var \PDO $pdo */
//        $pdo = $GLOBALS["PDO"];
//        $stmt = $pdo->prepare("UPDATE products SET price = price - ? WHERE id = ?");
//        $stmt->execute([$amount, $productId]);
//    }

    public static function getProduct($productId){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT p.id as id, price, quantity, s.name as subCat, c.name as cat,
                  m.name as model, b.name as brand, pi.img_uri FROM products as p
                  JOIN sub_categories as s ON p.subCategoryId = s.id
                  JOIN categories as c ON s.categoryId = c.id
                  JOIN models as m ON m.id = p.modelId
                  JOIN brands as b ON b.id = m.brandId
                  JOIN products_images as pi ON pi.productId = p.id WHERE p.id = :productId";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array('productId' => $productId));
        $row = $stmt->fetch(\PDO::FETCH_OBJ);
        $product = new Product($row->id, $row->price, $row->quantity, $row->subCat, $row->cat, $row->model, $row->brand, $row->img_uri);
        return $product;

    }

    public static function getSpecs($productId){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT ps.name,sv.value FROM products as p
                                         JOIN spec_values as sv ON sv.productId = p.id
                                         JOIN product_spec as ps ON sv.specID = ps.Id
                                         WHERE p.id = :productId");
        $stmt->execute(array('productId' => $productId));
        $specs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $specs;
    }

    public static function getOrderDetails($orderId){
        $query = "SELECT b.id, CONCAT(d.name, ' ', c.name) as productName, b.price * a.quantity as price, a.quantity FROM ordered_products as a 
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
        $query = "SELECT d.price,d.id,CONCAT(c.name, ' ', b.name) as productName, SUM(a.quantity) as totalSells, e.img_uri FROM ordered_products as a
                  LEFT JOIN products as d ON d.id = a.productId
                  LEFT JOIN models as b ON b.id = d.modelId
                  LEFT JOIN brands as c ON c.id = b.brandId
                  LEFT JOIN products_images as e ON b.id = e.productId
                  GROUP BY a.productId ORDER BY totalSells DESC LIMIT 5;";
        $stmt = $GLOBALS['PDO']->prepare($query);
        $stmt->execute();
        $topProducts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $topProducts;
    }

    public static function getAllPictureBrands(){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT DISTINCT SUM(a.quantity) AS totalQuantity, d.name,d.image_uri  FROM ordered_products as a
                                         LEFT JOIN products AS b ON b.id = a.productId
                                         LEFT JOIN sub_categories AS c ON c.id = b.subCategoryId
                                         LEFT JOIN brands AS d ON c.id = d.subCategoryId
                                         GROUP BY d.name ORDER BY totalQuantity DESC LIMIT 5");
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $brands = [];
        foreach ($rows as $row) {
            $brand = [];
            $brand ["image"] = $row["image_uri"];
            $brand ["name"] = $row["name"];
            $brands[] = $brand;
        }
        return $brands;
    }


    public static function getAutoLoadNames($text){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT a.id, CONCAT(c.name, ' ',b.name) as name FROM products as a
                  LEFT JOIN models as b ON b.id = a.modelId
                  LEFT JOIN brands as c ON c.id = b.brandId";
        $params = [];
        if (!empty($text)) {
            $query .= " HAVING name LIKE ?";
            $params[] = "%" . $text. "%";
        }
        $query .= " LIMIT 5";
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function checkBrandIdExist($brandName, $subCategoryId){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT id FROM brands WHERE subCategoryId = :subCategoryId AND name = :brandName;";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array('subCategoryId' => $subCategoryId, 'brandName' => $brandName));
        $brandId = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $brandId;
    }

    public static function checkModelIdExist($brandId, $modelName){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT id FROM models WHERE brandId = :brandId AND name = :modelName;";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array('brandId' => $brandId, 'modelName' => $modelName));
        $modelId = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $modelId;
    }

    public static function editProduct($price, $quantity, $productId){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "UPDATE products SET price = :price, quantity = :quantity
                  WHERE id = :id;";
        $stmt = $pdo->prepare($query);
        try {
            $stmt->execute(['id' => $productId, 'price' => $price, 'quantity' => $quantity]);
        } catch (\PDOException $e) {
            echo "Something went Wrong - " . $e->getMessage();
            return false;
        }
        return true;

    }

    public static function getAllCategories(){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT name FROM categories";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $brands = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $brands;
    }


    public static function checkQtyAvailabilityPerProduct(array $products){
        //This function check if the product is available for a given product id and quantity ordered.
        //If quantity ordered is bigger than the quantity in stock the function return assoc array
        //with the quantity(value) in stock of the given product(key)
        //The parameter given to this function is assoc array ['productId' => $quantity]
        //If more than one product/quantity is given and all products are available return true
        //If one of the given product/quantity is not available return the first occurrences

        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        foreach ($products as $productId => $quantity) {
            $query = "SELECT quantity FROM products WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array('id' => $productId));
            $quantityResult = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($quantityResult['quantity'] == 0 || $quantityResult['quantity'] < $quantity){
                $result['productId'] = $productId;
                $result['quantity'] = $quantityResult['quantity'];
                return $result;
            }
        }
        return true;
    }


    public static function showCartProducts($idList){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT p.id as id, price, quantity, s.name as subCat, c.name as cat,
                  m.name as model, b.name as brand, pi.img_uri as img FROM products as p
                  JOIN sub_categories as s ON p.subCategoryId = s.id
                  JOIN categories as c ON s.categoryId = c.id
                  JOIN models as m ON m.id = p.modelId
                  JOIN brands as b ON b.id = m.brandId
                  JOIN products_images as pi ON pi.productId = p.id 
                  WHERE p.id IN ($idList)";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $products = [];
        while ($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $products[] = new Product($row->id, $row->price, $row->quantity, $row->subCat, $row->cat, $row->model, $row->brand, $row->img);
        }
        return $products;
    }

    public static  function addToFavourites($userId, $productId){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "INSERT INTO favourites (userId, productId) VALUES (:userId , :productId)";
        $stmt = $pdo->prepare($query);
        $stmt ->execute(['userId' => $userId, 'productId' => $productId]);
    }

    public static function topBrandsProducts($brand){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $query = "SELECT p.id as id, price, quantity, s.name as subCat, c.name as cat,
                  m.name as model, b.name as brand, pi.img_uri as img FROM products as p
                  JOIN sub_categories as s ON p.subCategoryId = s.id
                  JOIN categories as c ON s.categoryId = c.id
                  JOIN models as m ON m.id = p.modelId
                  JOIN brands as b ON b.id = m.brandId
                  JOIN products_images as pi ON pi.productId = p.id WHERE b.name = :brand";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['brand' => $brand]);
        $products = [];
        while ($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $products[] = new Product($row->id, $row->price, $row->quantity, $row->subCat, $row->cat, $row->model, $row->brand, $row->img);
        }
        return $products;
    }

}