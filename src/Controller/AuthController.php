<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model\Entity\User;
use Hetic\ReshomeApi\Model\Manager\UserManager;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthController extends BaseController
{
    protected User $user;
    private string $secret;

    public function __construct()
    {
        parent::__construct();
        $this->secret = getenv('secret_key');
    }

    private function generateJwt($user) : string
    {
        $issuedAt = new \DateTimeImmutable();
        $expireAt = $issuedAt->modify('+1 day')->getTimestamp();

        $token = array(
            'iat' => $issuedAt->getTimestamp(),
            'iss' => 'http://localhost:8080',
            'nbf' => $issuedAt->getTimestamp(),
            'exp' => $expireAt,
            'data' => $user->getUserId()
        );

        return JWT::encode($token, $this->secret, 'HS256');
    }

    public function verifyJwt() : mixed
    {
        $jwt = $_SERVER['HTTP_AUTHORIZATION'] ?? null;
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

    public function login($username, $password)
    {
        $manager = new UserManager();
        $user = $manager->verifyCredentials($username, $password);
        if ($user) {
            $jwt = $this->generateJwt($user);
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(['token' => $jwt]);
        } else {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Invalid username or password']);
        }
    }

    public function register(array $data)
    {
        $manager = new UserManager();
        $user = $manager->create($data);
        if ($user) {
            $jwt = $this->generateJwt($user);
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(['token' => $jwt]);
        } else {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Unable to register']);
        }
    }


}