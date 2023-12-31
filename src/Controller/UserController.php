<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model\Manager\UserManager;

// Contrôleur pour la gestion des utilisateurs
class UserController extends BaseController
{
    // Méthode pour obtenir l'utilisateur connecté
    public function getLoggedUser(): void
    {
        // Vérification de l'authentification
        $auth = new AuthController();
        $user = $auth->verifyJwt();
        if ($user) {
            // Formatage des données en JSON
            header('Content-Type: application/json');
            echo json_encode([
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
                'phone_number' => $user->getPhoneNumber(),
                'address' => $user->getAddress(),
                'post_code' => $user->getPostCode(),
                'city' => $user->getCity(),
                'country' => $user->getCountry(),
                'is_staff' => $user->getIsStaff(),
                'is_admin' => $user->getIsAdmin(),
                'is_logistic' => $user->getIsLogistic()
            ]);
        }
        else {
            // Message d'erreur si le token est invalide ou manquant
            echo json_encode(['message' => 'Token invalide ou manquant']);
        }
    }

    // Méthode pour obtenir les détails d'un utilisateur
    public function getUserDetails($userId)
    {
        $auth = new AuthController();
        $user = $auth->verifyJwt();

        // Seul l'administrateur ou le staff peuvent accéder à ces données
        if ($user->getIsAdmin() || $user->getIsStaff()) {
            $manager = new UserManager();
            header('Content-Type: application/json');
            if ($manager->getUserById($userId)) {
                // Formatage des données en JSON
                echo json_encode($manager->getUserById($userId)->jsonSerialize());
                return;
            }
            // Message d'erreur si l'utilisateur n'a pas été trouvé
            echo json_encode(['message' => 'Erreur : Utilisateur non trouvé']);
        } else {
            // Message d'erreur si l'utilisateur n'a pas les droits nécessaires pour accéder à ces données
            echo json_encode(['message' => 'Erreur : Vous ne pouvez pas accéder à ces données']);
        }
    }
}
