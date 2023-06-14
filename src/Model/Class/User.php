<?php

namespace Hetic\ReshomeH\Model\Class;
use Hetic\ReshomeH\model\Bases\BaseClass;

class User extends BaseClass
{
    private $first_name;
    private $last_name;
    private $email;
    private $phone_number;
    private $hashed_password;
    private $address;
    private $post_code;
    private $city;
    private $country;
    private $is_staff;
    private $is_logistic;
    private $is_admin;
    private $user_id;

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    public function getHashedPassword()
    {
        return $this->hashed_password;
    }

    public function setHashedPassword($hashed_password)
    {
        $this->hashed_password = $hashed_password;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getPostCode()
    {
        return $this->post_code;
    }

    public function setPostCode($post_code)
    {
        $this->post_code = $post_code;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getIsStaff()
    {
        return $this->is_staff;
    }

    public function setIsStaff($is_staff)
    {
        $this->is_staff = $is_staff;
    }

    public function getIsLogistic()
    {
        return $this->is_logistic;
    }

    public function setIsLogistic($is_logistic)
    {
        $this->is_logistic = $is_logistic;
    }

    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
}
