<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model\Entity\User;
use Hetic\ReshomeApi\Model\Manager\UserManager;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthController extends BaseController
{
    protected User $user;
    private string $secret = 'verysecretpassword'; //TODO Faire marcher variables d'environnement


    private function generateJwt($user) : string
    {
        $issuedAt = new \DateTimeImmutable();
        $expireAt = $issuedAt->modify('+1 day')->getTimestamp();

        $token = array(
            'iat' => $issuedAt->getTimestamp(),
            'iss' => 'http://localhost:8080',
            'nbf' => $issuedAt->getTimestamp(),
            'exp' => $expireAt,
            'uid' => $user->getUserId()
        );

        return JWT::encode($token, $this->secret, 'HS256');
    }

    public function verifyJwt() : false|User
    {
        $bearer = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
        if (!$bearer) {
            return false;
        }

        $jwt = str_replace("Bearer ", "", $bearer);
        $manager = new UserManager();

        if (!$jwt) {
            return false;
        }

        try {

            $decoded = JWT::decode($jwt, new Key($this->secret, 'HS256'));
            return $manager->getUserById($decoded->uid);
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function login(): void
    {
        $username = $_POST['email'];
        $password = $_POST['password'];

        $manager = new UserManager();
        $user = $manager->verifyCredentials($username, $password);
        if ($user) {
            $jwt = $this->generateJwt($user);
            echo $jwt;
        } else {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Invalid username or password']);
        }
    }

    public function register() : void
    {
        $fields = ['first_name', 'last_name', 'email', 'phone_number', 'password'];
        $data = array_map('htmlspecialchars', $_POST);
        $data = array_intersect_key($data, array_flip($fields));

        $invalidCount = 0;
        foreach ($data as $value) {
            if (empty($value)) {
                $invalidCount += 1;
            }
        }

        if (!$invalidCount) {
            $manager = new UserManager();
            $user = $manager->create($data);
            if ($user) {
                $jwt = $this->generateJwt($user);
                http_response_code(200);
                echo $jwt;
            } else {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Unable to register']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['message' => $invalidCount . ' value(s) missing or invalid']);
        }



    }


}