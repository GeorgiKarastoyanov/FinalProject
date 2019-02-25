<?php
/**
 * Created by PhpStorm.
 * User: Natsi
 * Date: 22.2.2019 г.
 * Time: 19:45
 */

namespace model;
class User
{

    protected  $id;
    protected  $email;
    protected  $password;

    /**
     * User constructor.
     * @param $name
     * @param $age
     * @param $email
     * @param $password
     */
    public function __construct( $email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }



    /**
     * @param mixed $id
     */
    public function setId($id){
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}