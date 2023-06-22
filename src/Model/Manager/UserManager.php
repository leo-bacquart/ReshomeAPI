<?php

namespace Hetic\ReshomeApi\Model\Manager;

use Hetic\ReshomeApi\Model\Bases\BaseManager;
use Hetic\ReshomeApi\Model\Entity\User;

class UserManager extends BaseManager
{
    public function create(array $userData) : mixed
    {
        $query = 'INSERT INTO User (first_name, last_name, email, phone_number, hashed_password, address, post_code, city, country) VALUES (:first_name, :last_name, :email, :phone_number, :hashed_password, :address, :post_code, :city, :country)';
        $stmt = $this->db->prepare($query);
        $hashedPassword = password_hash($userData['password'], PASSWORD_BCRYPT);
        $stmt->execute([
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
            'email' => $userData['email'],
            'phone_number' => $userData['phone_number'],
            'hashed_password' => $hashedPassword,
            'address' => $userData['address'],
            'post_code' => $userData['post_code'],
            'city' => $userData['city'],
            'country' => $userData['country'],
        ]);

        if ($stmt->rowCount() > 0) {
            return $this->getUserById($this->db->lastInsertId());
        } else {
            return false; // No rows were inserted
        }
    }

    public function getUserById($id) : mixed
    {
        $query = 'SELECT * FROM User WHERE user_id= :id';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, User::class);
        $stmt->execute([
            'id' => intval(htmlspecialchars($id))
        ]);
        $response = $stmt->fetch();
        if ($response) {
            return $response;
        }
        else {
            return false;
        }
    }

    public function getUserPage($number) : array
    {
        $offset = ($number - 1) * 10;

        $query = "SELECT * FROM User ORDER BY user_id LIMIT 10 OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, User::class);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function verifyCredentials($email, $password) : mixed
    {
        $query = 'SELECT * FROM User WHERE email= :email';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, User::class);
        $stmt->execute([
            'email' => htmlspecialchars($email)
        ]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user->getHashedPassword())) {
            return $user;
        }

        return false;
    }

    public function update(User $user)
    {
        $hashedPassword = password_hash($user->getHashedPassword(), PASSWORD_BCRYPT);
        $query = 'UPDATE User SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, hashed_password = :hashed_password, address = :address, post_code = :post_code, city = :city, country = :country, is_staff = :is_staff, is_logistic = :is_logistic, is_admin = :is_admin WHERE user_id = :user_id';
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
            'phone_number' => $user->getPhoneNumber(),
            'hashed_password' => $hashedPassword,
            'address' => $user->getAddress(),
            'post_code' => $user->getPostCode(),
            'city' => $user->getCity(),
            'country' => $user->getCountry(),
            'is_staff' => $user->getIsStaff(),
            'is_logistic' => $user->getIsLogistic(),
            'is_admin' => $user->getIsAdmin()
        ]);
    }

    public function deleteUser(int $userId) : void
    {
        $query = 'DELETE FROM User WHERE user_id = :user_id';
        $stmt = $this->db->prepare($query);
        $stmt->execute(['user_id' => $userId]);
    }
}