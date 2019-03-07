<?php
/**
 * Created by PhpStorm.
 * User: STRYGWYR
 * Date: 2/24/2019
 * Time: 2:05 PM
 */

namespace model;


class UserInfo extends User
{
    protected $firstName;
    protected $lastName;
    protected $address;
    protected $isAdmin;

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * UserInfo constructor.
     * @param $firstName
     * @param $lastName
     * @param $address
     */
    public function __construct($email,$password,$firstName, $lastName, $address = null, $isAdmin = false)
    {
        parent::__construct($email, $password);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address = $address;
        $this->isAdmin =  $isAdmin;
    }


    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }
}