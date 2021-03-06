<?php

namespace model;

class UserDao{

    public static function addUser(User $user){
       $email= $user->getEmail();
       $password= $user->getPassword();
       $firstName = $user->getFirstName();
       $lastName = $user->getLastName();
       $query = "INSERT INTO users (email, password, firstName, lastName) 
                 VALUES (:email, :password, :firstName, :lastName);";
       $stmt = $GLOBALS['PDO']->prepare($query);
        try{
        $stmt->execute(array('email' => $email,'password' => $password, 'firstName' => $firstName, 'lastName' => $lastName));
            $userId = $GLOBALS['PDO']->lastInsertId();
        }
        catch (\Exception $e){
            echo $e->getMessage();
            return false;

        }
        return $userId;
    }

    public static function getUserByEmail($email){

        $query = "SELECT id, email, firstName, lastName, address, isAdmin FROM users WHERE email = :email;";
        $stmt = $GLOBALS['PDO']->prepare($query);
        $stmt->execute(array('email' => $email));
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }

    public static function existUserByEmail($email){
        $user_query = "SELECT email FROM users WHERE email = :email;";
        $stmt = $GLOBALS["PDO"]->prepare($user_query);
        $stmt->execute(array('email' => $email));
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return boolval($user);
    }

    public static function getPasswordByEmail($email){
        $query = "SELECT password FROM users WHERE email = :email;";
        $stmt = $GLOBALS['PDO']->prepare($query);
        $stmt->execute(array('email' => $email));
        $password = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $password['password'];
    }

    public static function delete($user_id){

        $query = "UPDATE users SET email='DELETED':id, password='DELETED', firstName='DELETED', lastName='DELETED', address='DELETED' WHERE id = :userId LIMIT 1;";
        $stmt = $GLOBALS['PDO']->prepare($query);
        try{
            $stmt->execute(array('id' => $user_id, 'userId' => $user_id));

        }
        catch (\Exception $e){
            return false;

        }
        return true;
    }

    public static function editProfile(User $user){
        $query = "UPDATE users SET email = :email,";
        $params = [];
        $email = $user->getEmail();
        $params["email"] = $email;
        //password
        if($user->getPassword()){
            $password = $user->getPassword();
            $params["password"] = $password;
            $query .= " password = :password,";
        }
        $query .= " firstName = :firstName, lastName = :lastName, address = :address WHERE id = :id;";

        $firstName = $user->getFirstName();
        $params["firstName"] = $firstName;

        $lastName = $user->getLastName();
        $params["lastName"] = $lastName;

        $address = $user->getAddress();
        $params["address"] = $address;

        $id = $user->getId();
        $params["id"] = $id;

        try{
            $stmt = $GLOBALS['PDO']->prepare($query);
            $stmt->execute($params);

        }
        catch (\Exception $e){
            echo $e->getMessage();
            return false;

        }
        return true;
    }

    public static function getAllOrders($userId){
        $query = "SELECT id, date FROM orders WHERE userId = :id;";
        $stmt = $GLOBALS['PDO']->prepare($query);
        $stmt->execute(array('id' => $userId));
        $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $orders;
    }

    public static function getFavorites($userId){
        $query = "SELECT b.id as productId,CONCAT(e.name, ' ', d.name) as productName, b.price FROM favourites as a 
                  LEFT JOIN products as b ON a.productId = b.id
                  LEFT JOIN models as d ON d.id = b.modelId
                  LEFT JOIN brands as e ON e.id = d.brandId
                  WHERE a.userId = :id;";
        $stmt = $GLOBALS['PDO']->prepare($query);
        $stmt->execute(array('id' => $userId));
        $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $orders;
    }

    public static function removeFavorite($productId, $userId){
        $query = "DELETE FROM favourites WHERE userId = :userId AND productId = :productId LIMIT 10";
        $stmt = $GLOBALS['PDO']->prepare($query);

        try{
            $stmt->execute(array('userId' => $userId, 'productId' => $productId));
        }
        catch (\Exception $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }

    public static function buyAction(array $orderProducts, $userId ){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $pdo->beginTransaction();
        try {
            //First - subtract stock quantity from order quantity per product
            foreach ($orderProducts as $productId => $product) {
                $query = "UPDATE products SET quantity = quantity - :quantity
                      WHERE id = :productId ;";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['quantity' => $product['quantity'], 'productId' => $productId]);
            }

            //Second - insert order in table orders (order id, user, and date) and get the order id for last insertion
            $query = "INSERT INTO orders (userId,date) VALUES (:userId, NOW());";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['userId' => $userId]);
            $orderId = $pdo->lastInsertId();
            //Third - insert ordered products in table ordered_products
            foreach ($orderProducts as $productId => $product){
                $query = "INSERT INTO ordered_products (orderId,productId,quantity,singlePrice) VALUES (:orderId, :productId, :quantity, :singlePrice);";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'quantity' => $product['quantity'],
                                'singlePrice' => $product['price']]);
            }

            $pdo->commit();
        } catch (\PDOException $e) {
            echo "Something went Wrong - " . $e->getMessage();
            $pdo->rollBack();
            return false;
        }
        return true;

    }

    public static function addUserAddress($userId,$address){
        $query = "UPDATE users SET address = :address WHERE id = :id;";
        $stmt = $GLOBALS['PDO']->prepare($query);
        try{
            $stmt->execute(array('address' => $address, 'id' => $userId));
        }
        catch (\Exception $e){
            echo $e->getMessage();
            return false;

        }
        return true;
    }

}

