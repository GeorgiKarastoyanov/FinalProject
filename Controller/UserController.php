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

        if (strlen($_POST['password']) < 2){
            throw new CustomException('Password must be at least 3 characters long!');
        }

        if (strlen($_POST['confirm-password']) < 2){
            throw new CustomException('Confirm-Password must be at least 3 characters long!');
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

        header("Location: ?target=home&action=index");

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
        $passwordHash = UserDao::getPasswordByEmail($_SESSION['login_email']);
        if(! password_verify($_POST['password'],$passwordHash)) {
            throw new CustomException('Invalid password!');
        }
        $user = UserDao::getUserByEmail($_SESSION['login_email']);
        $_SESSION['user']['id'] = $user['id'];
        $_SESSION['user']['email'] = $user['email'];
        $_SESSION['user']['firstName'] = $user['firstName'];
        $_SESSION['user']['lastName'] = $user['lastName'];
        $_SESSION['user']['address'] = $user['address'];
        unset($_SESSION['login_email']);
        header("Location: ?target=home&action=index");

    }

    public function logout(){
        unset($_SESSION['user']);
        header("Location: ?target=home&action=index");
    }

    public function delete(){
        if(!isset($_SESSION['user']['id'])) {
            throw new CustomException('Invalid account for deletion!');
        }
        if(!UserDao::delete($_SESSION['user']['id'])){
            throw new CustomException('Account not deleted!');

        }
        $this->logout();
    }

    public function edit_profile(){
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== "post") {
            throw new NotFoundException();
        }

        if(! isset($_POST['edit-profile'])) {
            throw new NotFoundException();
        }


        //first name
        if(! isset($_POST['first-name'])){
            $firstName = false;
        }
        else if(strlen($_POST['first-name']) < 2){
            throw new CustomException('First name must be at least two characters long!');
        }
        else{
            $firstName = $_POST['first-name'];
        }

        //last name
        if(! isset($_POST['last-name'])){
            $lastName = false;
        }
        else if(strlen($_POST['last-name']) < 2){
            throw new CustomException('Last name must be at least two characters long!');
        }
        else{
            $lastName = $_POST['last-name'];
        }

        //email
        if (! isset($_POST['email']) && $_POST['email'] == ''){
            $email = false;
        }
        else if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidParameterException('Invalid parameter email!');
        }
        else{
            $email = trim($_POST['email']);
        }

        //password
        if (! isset($_POST['password']) && ! isset($_POST['confirm-password']) ||
            ($_POST['password'] == '' && $_POST['confirm-password'] == '')){
            $password = false;

        }
        else if (! isset($_POST['password']) || ! isset($_POST['confirm-password'])){
            throw new CustomException('You must enter both password field!');
        }
        else if (strlen($_POST['password']) < 2){
            throw new CustomException('Password must be at least 3 characters long!');
        }
        else if (strlen($_POST['confirm-password']) < 2){
            throw new CustomException('Confirm-Password must be at least 3 characters long!');
        }
        else if($_POST['password'] !== $_POST['confirm-password']){
            throw new CustomException('Passwords do not match!');
        }
        else{
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT, ["cost"=>5]);
        }

        //address
        if (! isset($_POST['address']) && $_POST['address'] == ''){
            $address = false;
        }
        elseif(strlen($_POST['address']) < 3){
            throw new CustomException('Address must be at least 3 characters long!');
        }
        else{
            $address = $_POST['address'];
        }

        $user = new UserInfo($email, $password, $firstName, $lastName, $address);
        $user->setId($_SESSION['user']['id']);
        if(! UserDao::editProfile($user)){
            throw new CustomException('Profile not edited!');
        }
        throw new CustomException('Bravo');
//        $sessionEmail = isset($_POST['email']) ? $_POST['email'] : $_SESSION['user']['email'];
//        $user =
//        if(! UserDao::getUserByEmail($sessionEmail)){
//            throw new CustomException('Cant fetch new profile information!');
//        }



        //header("Location: ?target=home&action=index");


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