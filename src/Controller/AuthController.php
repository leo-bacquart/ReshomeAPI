<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model\Entity\User;
use Hetic\ReshomeApi\Model\Manager\UserManager;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends BaseController
{
    protected User $user;
    // TODO: À remplacer par une clé secrète stockée de manière sécurisée (ex: variable d'environnement)
    private string $secret = 'verysecretpassword';


    // Génère un JWT (Jetons Web JSON) pour un utilisateur donné
    private function generateJwt($user) : string
    {
        $issuedAt = new \DateTimeImmutable();
        $expireAt = $issuedAt->modify('+1 day')->getTimestamp();

        $token = array(
            'iat' => $issuedAt->getTimestamp(),  // Date de création du token
            'iss' => 'http://localhost:8080',    // Émetteur (dans ce cas, l'hôte local)
            'nbf' => $issuedAt->getTimestamp(),  // Token actif à partir de...
            'exp' => $expireAt,                  // Date d'expiration
            'uid' => $user->getUserId()          // Identifiant de l'utilisateur
        );

        // Encode et renvoie le jeton
        return JWT::encode($token, $this->secret, 'HS256');
    }

    // Vérifie si un JWT est valide et renvoie l'utilisateur correspondant
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
            // Essaye de décoder le jeton
            $decoded = JWT::decode($jwt, new Key($this->secret, 'HS256'));
            // Renvoie l'utilisateur correspondant
            return $manager->getUserById($decoded->uid);
        } catch (\Exception $exception) {
            // Si une erreur se produit (par exemple, jeton invalide), renvoie false
            return false;
        }
    }

    // Connecte un utilisateur et renvoie un JWT en cas de succès
    public function login($username, $password)
    {
        $manager = new UserManager();
        $user = $manager->verifyCredentials($username, $password);
        if ($user) {
            // Si les identifiants sont valides, génère un JWT
            $jwt = $this->generateJwt($user);
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode(['token' => $jwt]);
        } else {
            // Sinon, renvoie une erreur 401 (non autorisé)
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Identifiant ou mot de passe invalide']);
        }
    }

    // Inscrit un nouvel utilisateur
    public function register() : void
    {
        $fields = ['first_name', 'last_name', 'email', 'phone_number', 'password', 'address', 'post_code', 'city', 'country'];
        $data = array_map('htmlspecialchars', $_POST); // Nettoie les valeurs de $_POST
        $data = array_intersect_key($data, array_flip($fields)); // Filtrer les valeurs inutiles

        $invalidCount = 0;
        foreach ($data as $value) {
            // Compte les valeurs manquantes ou invalides
            if (empty($value)) {
                $invalidCount += 1;
            }
        }

        if (!$invalidCount) {
            $manager = new UserManager();
            $user = $manager->create($data); // Crée un nouvel utilisateur
            if ($user) {
                // Si l'inscription est réussie, génère un JWT
                $jwt = $this->generateJwt($user);
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode(['token' => $jwt]);
            } else {
                // Si l'inscription échoue, renvoie une erreur 400 (Bad Request)
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Inscription impossible']);
            }
        } else {
            // S'il manque des valeurs, renvoie un message d'erreur
            header('Content-Type: application/json');
            echo json_encode(['message' => $invalidCount . ' valeur(s) manquante(s) ou invalide(s)']);
        }
    }
}

