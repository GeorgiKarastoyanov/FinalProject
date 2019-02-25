<?php
namespace controller;

use exception\CustomException;
use exception\InvalidParameterException;
use exception\NotFoundException;
use Model\UserDao;
use model\UserInfo;

class UserController extends BaseController
{

    public function register_email()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        if (! isset($_POST['email']) || ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidParameterException('Invalid parameter email!');
        }

        $email = trim($_POST['email']);

        if (UserDao::existUserByEmail($email)) {
            throw new CustomException('Email already exists!');
        }

        $_SESSION['register_email'] = $email;

        $this->register_user_view();
    }

    public function register_user(){
        if(! isset($_SESSION['register_email'])){
            throw new CustomException('Register email not passed!');
        }

        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        if (! isset($_POST['first-name']) || strlen($_POST['first-name']) < 2){
           throw new CustomException('First name must be at least two characters long!');
        }

        if(! isset($_POST['last-name']) || strlen($_POST['last-name']) < 2){
            throw new CustomException('Last name must be at least two characters long!');
        }

        if (! isset($_POST['password']) || ! isset($_POST['confirm-password'])){
            throw new CustomException('You must enter password!');
        }

        if (strlen($_POST['password']) < 10){
            throw new CustomException('Password must be at least 10 characters long!');
        }

        if (strlen($_POST['confirm-password']) < 10){
            throw new CustomException('Confirm-Password must be at least 10 characters long!');
        }

        if($_POST['password'] !== $_POST['confirm-password']){
            throw new CustomException('Passwords do not match!');
        }
        $email = $_SESSION['register_email'];
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost"=>5]);
        $firstName = $_POST['first-name'];
        $lastName = $_POST['last-name'];
        $user = new UserInfo($email, $password, $firstName, $lastName);
        $userId = UserDao::addUser($user);
        if(! $userId) {
            throw new CustomException('User not added!');
        }

        $user->setId($userId);
        $_SESSION['user']['id'] = $userId;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['firstName'] = $firstName;
        $_SESSION['user']['lastName'] = $lastName;
        $_SESSION['user']['address'] = $user->getAddress();

        unset($_SESSION['register_email']);

        HomeController::index();

    }

    public function login_email(){
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        if(! isset($_POST['email'])) {
            throw new CustomException('You must enter email!');
        }

        if(! UserDao::existUserByEmail($_POST['email'])) {
            throw new CustomException('Invalid email!');
        }
        $_SESSION['login_email'] = $_POST['email'];
        $this->login_user_view();

  }

    public function login_user(){
        if(! isset($_SESSION['login_email'])){
            throw new CustomException('Login email not passed!');
        }
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        if(! isset($_POST['password'])) {
            throw new CustomException('Please enter your password!');
        }

        if(! password_verify($_POST['password'],UserDao::getPasswordByEmail($_SESSION['login_email']))) {
            throw new CustomException('Invalid password!');
        }
        $user = UserDao::getUserByEmail($_SESSION['login_email']);

        $_SESSION['user']['id'] = $user->getId();
        $_SESSION['user']['email'] = $user->getEmail();
        $_SESSION['user']['firstName'] = $user->getFirstName();
        $_SESSION['user']['lastName'] = $user->getLastName();
        $_SESSION['user']['address'] = $user->getAddress();

        unset($_SESSION['login_email']);

        HomeController::index();

    }

    public function login_email_view(){
        require_once "View/login-email.html";
    }
    public function login_user_view(){
        require_once "View/login-user.html";
    }
    public function register_email_view(){
        require_once "View/register-email.html";
    }
    public function register_user_view(){
        require_once "View/register-user.html";
    }
}