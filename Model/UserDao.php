<?php

namespace model;
class UserDao{
    public static function addUser(UserInfo $user){
       $email= $user->getEmail();
       $password= $user->getPassword();
       $firstName = $user->getFirstName();
       $lastName = $user->getLastName();
       $query = "INSERT INTO users (email, password, firstName, lastName) VALUES (:email, :password, :firstName, :lastName);";
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

        $query = "SELECT id, email, firstName, lastName, address FROM users WHERE email = :email;";
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
        $query = "UPDATE users SET email='DELETED', password='DELETED', firstName='DELETED', lastName='DELETED', address='DELETED'
                  WHERE id = :id LIMIT 1;";
        $stmt = $GLOBALS['PDO']->prepare($query);
        try{
            $stmt->execute(array('id' => $user_id));

        }
        catch (\Exception $e){
            echo $e->getMessage();
            return false;

        }
        return true;
    }

    public static function editProfile(UserInfo $user){
        $query = "UPDATE users SET";
        $params = [];

        //email
        if($user->getEmail()){
            $email = $user->getEmail();
            $query .= " email = :$email";
            $params["email"] = $email;
        }
        //password
        if($user->getPassword()){
            $password = $user->getEmail();
            $params["password"] = $password;
            if(!$user->getEmail()){
                $query .= " password = :password";
            }
            else{
                $query .= ", password = :password";
            }
        }
        //first name
        if($user->getFirstName()){
            $firstName = $user->getFirstName();
            $params["firstName"] = $firstName;
            if(!$user->getEmail()&& !$user->getPassword()){
                $query .= " firstName = :firstName";
            }
            else{
                $query .= ", firstName = :firstName";
            }
        }

        //last name
        if($user->getLastName()) {
            $lastName = $user->getLastName();
            $params["lastName"] = $lastName;
            if(!$user->getEmail() && !$user->getPassword() && !$user->getFirstName()){
                $query .= " lastName = :lastName";
            }
            else{
                $query .= ", lastName = :lastName";
            }
        }

        //address
        if($user->getAddress()) {
            $address = $user->getAddress();
            $params["address"] = $address;
            if(!$user->getEmail()&& !$user->getPassword() && !$user->getFirstName() && !$user->getLastName()){
                $query .= " address = :address";
            }
            else{
                $query .= ", address = :address";
            }
        }
        $query .= " WHERE id = :id;";
        $params['id'] = $user->getId();
        //dd($params,$query);
        $stmt = $GLOBALS['PDO']->prepare($query);
        try{
            $stmt->execute($params);

        }
        catch (\Exception $e){
            echo $e->getMessage();
            return false;

        }
        return true;
    }
}

