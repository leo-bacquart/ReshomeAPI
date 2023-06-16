<?php

namespace Hetic\ReshomeApi\Model\Manager;

use Hetic\ReshomeApi\Model\Bases\BaseManager;
use Hetic\ReshomeApi\Model\Entity\User;

class UserManager extends BaseManager
{
    public function create(array $userData) : User
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

        return $this->getUserById($this->db->lastInsertId());
    }

    // Utilisé uniquement par la fonction Create (sinon faille de sécu)
    private function getUserById($id) : User
    {
        $query = 'SELECT * FROM User WHERE user_id= :id';
        $stmt = $this->db->prepare($query);
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, User::class);
        $stmt->execute([
            'email' => htmlspecialchars($id)
        ]);
        return $stmt->fetch();
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
}