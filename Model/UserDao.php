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
        $query = "SELECT id, email, firstName, lastName, adress FROM users WHERE email = :email;";
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
        return $password;
    }
}

